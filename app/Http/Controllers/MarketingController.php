<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Events\Notify;
use App\Helpers\CrmHelper;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\MarketingTask;
use App\Jobs\TaskBasedReport;
use App\Models\MarketingClient;
use App\Models\MarketingStatus;
use App\Services\CompanyService;
use App\Services\MarketingService;
use App\Models\MarketingClientComment;
use App\Models\MarketingClientCategory;
use App\Repositories\MarketingRepository;
use Illuminate\Support\Facades\Auth;

class MarketingController extends BaseController
{
    protected MarketingRepository $repository;
    protected CompanyService $service;
    protected MarketingService $marketing_service;

    public function __construct(MarketingRepository $marketing_repository, CompanyService $company_service,MarketingService $marketing_service)
    {
        parent::__construct();
        $this->repository = $marketing_repository;
        $this->service = $company_service;
        $this->marketing_service = $marketing_service;
    }

    public function index()
    {
        $clients = MarketingClient::with(['comments.user','tasks'])->orderBy('created_at', 'desc')->get();
        $statuses = MarketingStatus::withCount('client')->get();
        $categories = MarketingClientCategory::all();
        $company_users = $this->service->getAuthUserCompany();
        $users = $company_users->users()->get();
        return view('marketing.index',compact('clients','statuses','categories','users'));
    }

    public function filterUsers(Request $request)
    {
        if($request->has('search_key') && $request->search_key != ''){
            $users = User::where('name','like','%' . $request->search_key . '%')->get();
        }else{
            $company_users = $this->service->getAuthUserCompany();
            $users = $company_users->users()->get();
        }
        return [
            "data" => $users,
        ];
    }

    public function saveAssignedUsers(Request $request){
        $client = MarketingClient::find($request->id);
        $client->assigned_to = json_encode($request->users);
        $client->save();

        foreach($request->users as $user){
            $user_id = $user;
            $message = "You have assigned to client : " . $client->name;
            $created_by = Auth::user()->id;
            $this->marketing_service->sendNotification($user_id,$message,$created_by);
        }

        $clients = MarketingClient::with(['comments.user','tasks'])->orderBy('created_at', 'desc')->get();
        return [
            'data' => $clients
        ];
    }


    public function saveMarketingClient(Request $request)
    {
        $this->repository->saveMarketingClient($request->all());
        $clients = MarketingClient::with(['comments.user','tasks'])->orderBy('created_at', 'desc')->get();
        $statuses = MarketingStatus::withCount('client')->get();
        return [
            "data" => $clients,
            "statuses" => $statuses,
            "message" => "Marketing client saved successfully"
        ];
    }

    public function saveMarketingClientCategory(Request $request)
    {
        $this->repository->saveMarketingClientCategory($request->all());
        $categories = MarketingClientCategory::all();
        return [
            "data" => $categories,
            "message" => "Client category saved successfully"
        ];
    }


    public function saveStatus(Request $request)
    {
        $this->repository->saveStatus($request->all());
        $statuses = MarketingStatus::withCount('client')->get();

        return [
            "data" => $statuses,
            "message" => "New status added successfully"
        ];
    }

    public function updateStatus(Request $request){
        $this->repository->updateStatus($request->all());
        $statuses = MarketingStatus::withCount('client')->get();

        return [
            "data" => $statuses,
            "message" => "Status updated successfully"
        ];
    }

    public function changeClientStatus(Request $request){
        $this->repository->changeClientStatus($request->all());
        $clients = MarketingClient::with(['comments.user','tasks'])->orderBy('created_at', 'desc')->get();
        $statuses = MarketingStatus::withCount('client')->get();
        return [
            "data" => $clients,
            "statuses" => $statuses,
            "message" => "Client status changed successfully"
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createClientComment(Request $request){
        $data = $request->only(['client_id', 'description', 'created_by']);
        $data['created_by'] = auth()->user()->id;
        MarketingClientComment::create($data);
        foreach ($request->notify ?? [] as  $item){
            $user_id = $item['id'];
            $created_by = $data['created_by'];
            $message = $data['description'];

            $this->marketing_service->sendNotification($user_id,$message,$created_by);
        }

        $clients = MarketingClient::with(['comments.user','tasks'])->orderBy('created_at', 'desc')->get();
        $status = MarketingStatus::withCount('client')->get();
        return [
            "data" => $clients,
            "status" => $status,
            "message" => "Client comment updated successfully"
        ];
    }

    public function saveTask(Request $request)
    {
        $this->repository->saveTask($request->all());
        $clients = MarketingClient::with(['comments.user','tasks'])->orderBy('created_at', 'desc')->get();
        $statuses = MarketingStatus::withCount('client')->get();
        $client = MarketingClient::find($request->client_id);

        $user_id = $created_by = Auth::user()->id;
        $formated_date = $this->formatJsDateObject($request->due_date);
        $due_date = Carbon::parse($formated_date)->format('d M,Y H:i A');
        $message = "You have schedule a call at: " . $due_date . " for client: " . $client->name;

        $this->marketing_service->sendNotification($user_id,$message,$created_by);

        return [
            "error" => false,
            "data" => $clients,
            "active_client_id" => $request->client_id,
            "statuses" => $statuses,
            "message" => "Task created successfully",
        ];
    }


    public function emailToClient(Request $request)
    {
        if(isset($request->clients) && count($request->clients)){
            foreach($request->clients ?? [] as $client){
                logger($client);
                $user = [
                    'name' => $client['text'],
                    'email' => $client['email'],
                ];
                $this->dispatch(new TaskBasedReport($user, $request->subject, $request->message));
            }

            return [
                "message" => "Group email sent successfully",
                "error" => false
            ];
        }
        if(isset($request->email)){
            $client = MarketingClient::where('email', $request->email)->first();
            if($client){
                $this->dispatch(new TaskBasedReport($client, $request->subject, $request->message));

                return [
                    "message" => "Email sent successfully",
                    "error" => false
                ];
            }
        }

        return [
            "message" => "Unable to send email",
            "error" => true
        ];
    }
}
