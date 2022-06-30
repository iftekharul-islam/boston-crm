<?php

namespace App\Http\Controllers;

use App\Helpers\CrmHelper;
use App\Models\CallLog;
use App\Models\Order;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use CrmHelper;

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
        $newTicket->subject = $request->subject;
        $newTicket->issue = $request->issue;
        $newTicket->created_by = $user->id;
        $newTicket->save();

        $historyTitle = "Issue/Query created successfully";


        $orderData = $this->orderDetails($id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'data' => $orderData
        ];
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();
        $user = auth()->user();

        if (!$ticket) {
            return response()->json([
                'error' => true,
                'message' => 'Ticket Information Not Found'
            ]);
        }

        $ticket->subject = $request->subject;
        $ticket->issue = $request->subject;
        if($request->solution){
            $ticket->assigned_to = $user->id;
            $ticket->solution = $request->solution;
            $ticket->solution_by = $user->id;
            $ticket->solution_at = Carbon::now();
            $ticket->status = 1;
        }
        $ticket->updated_by = $user->id;
        $ticket->save();

        $historyTitle = "Issue updated successfully";


        $orderData = $this->orderDetails($ticket->order_id);
        return [
            'error' => false,
            'message' => $historyTitle,
            'data' => $orderData
        ];
    }
}
