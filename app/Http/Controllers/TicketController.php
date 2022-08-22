<?php

namespace App\Http\Controllers;

use App\Events\Notify;
use App\Helpers\CrmHelper;
use App\Models\CallLog;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Ticket;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    use CrmHelper;
    protected OrderRepository $repository;

    public function __construct(OrderRepository $order_repository)
    {
        $this->repository = $order_repository;
    }

    public function index($id)
    {
        return Ticket::where('order_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request, $id)
    {
        $order = Order::find($id);
        $user = auth()->user();

        if (!$order) {
            return response()->json([
                'error' => true,
                'message' => 'Order Information Not Found'
            ]);
        }

        $newTicket = new Ticket();
        $newTicket->order_id = $id;
        $newTicket->assigned_to = $request->assignTo ?? null;
        $newTicket->mention_to = $request->mentionTo;
        $newTicket->subject = $request->subject;
        $newTicket->issue = $request->issue;
        $newTicket->created_by = $user->id;
        $newTicket->save();

        foreach ($newTicket->mention_to ?? [] as $mention){
            $notification = new Notification();
            $notification->user_id = $mention['id'];
            $notification->message = 'Mention on issue to order no: '. $order['client_order_no'] ;
            $notification->created_by = $user->id;
            $notification->save();

            event(new Notify($notification->message, $notification->user_id));
        }

        $historyTitle = "Issue/Query created successfully";

        $data = [
            "activity_text" => "Issue/Query created successfully",
            "activity_by" => Auth::id(),
            "order_id" => $order->id
        ];

        $this->repository->addActivity($data);

        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'data' => $orderData
        ];
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::with('order')->where('id', $id)->first();
        $user = auth()->user();

        if (!$ticket) {
            return response()->json([
                'error' => true,
                'message' => 'Ticket Information Not Found'
            ]);
        }

        $ticket->subject = $request->subject;
        $ticket->issue = $request->issue;
        if($request->solution){
            $ticket->assigned_to = $user->id;
            $ticket->solution = $request->solution;
            $ticket->solution_by = $user->id;
            $ticket->mention_to = $request->mentionTo;
            $ticket->solution_at = Carbon::now();
            $ticket->status = 1;
        }
        foreach ($ticket->mention_to ?? [] as $mention){
            $notification = new Notification();
            $notification->user_id = $mention['id'];
            $notification->message = 'Mention on issue to order no: '.$ticket['order']['client_order_no'] ;
            $notification->created_by = $user->id;
            $notification->save();

            event(new Notify($notification->message, $notification->user_id));
        }
        $ticket->updated_by = $user->id;
        $ticket->save();

        $historyTitle = "Issue solution added successfully";

        $data = [
            "activity_text" => "Issue solution added successfully",
            "activity_by" => Auth::id(),
            "order_id" => $ticket->order_id
        ];

        $this->repository->addActivity($data);


        $orderData = $this->orderDetails($ticket->order_id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'data' => $orderData
        ];
    }

    public function getTicketByType($type)
    {
        $page_number = request()->query('page');
        $search_key = request()->query('searchKey') ?? '';

        $tickets = $this->getTickets($type, $page_number, $search_key);

        return response()->json([
            'data' => $tickets,
        ]);
    }

    public function getTickets(string $type, int $page_number,string $search_key): array
    {
        return $this->getTicketData(strtolower($type), $page_number,$search_key);
    }

    public function getTicketData(string $type, int $page_number, string $search_key): array
    {
        $data = [];
        $data['all'] = Ticket::count();
        $data['open'] = Ticket::where('status', '!=', 1)->count();
        $data['my'] =Ticket::where('assigned_to', auth()->user()->id)->count();

        if ($search_key == '') {
            if ($type == 'open') {
                $data['tickets'] = Ticket::with('order.lender', 'assignedUser')->where('status', '!=', 1)->paginate(10, ['*'], 'page', $page_number);
            } elseif ($type == 'my') {
                $data['tickets'] = Ticket::with('order.lender', 'assignedUser')->where('assigned_to', auth()->user()->id)->paginate(10, ['*'], 'page', $page_number);
            } else {
                $data['tickets'] = Ticket::with('order.lender', 'assignedUser')->paginate(10, ['*'], 'page', $page_number);
                $data['pageNumber'] = $page_number;
            }
        } else {
            if ($type == 'open') {
                $data['tickets'] = Ticket::with('order.lender', 'assignedUser')
                    ->Where('subject', 'like', '%' . $search_key . '%')
                    ->where('status', '!=', 1)
                    ->paginate(10, ['*'], 'page', $page_number);
            } elseif ($type == 'my') {
                $data['tickets'] = Ticket::with('order.lender', 'assignedUser')
                    ->Where('subject', 'like', '%' . $search_key . '%')
                    ->where('assigned_to', auth()->user()->id)
                    ->paginate(10, ['*'], 'page', $page_number);
            }  else {
                $data['tickets'] = Ticket::with('order.lender', 'assignedUser')
                    ->Where('subject', 'like', '%' . $search_key . '%')
                    ->paginate(10, ['*'], 'page', $page_number);
                $data['pageNumber'] = $page_number;
            }
        }
        return $data;
    }
}
