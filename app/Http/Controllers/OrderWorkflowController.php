<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\CrmHelper;
use App\Models\OrderWReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\GoogleCalendar\Event;
use App\Services\OrderWorkflowService;
use App\Repositories\OrderWorkflowRepository;


class OrderWorkflowController extends BaseController
{
    protected OrderWorkflowService $service;
    protected OrderWorkflowRepository $repository;
    use CrmHelper;

    public function __construct(OrderWorkflowService $order_w_service, OrderWorkflowRepository $order_w_repository)
    {
        parent::__construct();
        $this->service = $order_w_service;
        $this->repository = $order_w_repository;
    }

    public function updateOrderSchedule(Request $request){
        $this->repository->updateOrderScheduleData($request->all());
        //work for set event on google calender
        $this->service->setOrderSchedule($request->order_id);

        return response()->json(['message' => 'Schedule has been updated successfully']);
    }

    public function checkEvent(){
        //create a new event
//        $event = new Event;
//
//        $event->name = '580 E 2Nd St, Unit 3, Boston, Massachusetts, Suffolk, 02127 Safayet Hoque (Micelotta, Daniel 781-987-4946) ';
//        $event->description = 'Event description';
//        $event->startDateTime = Carbon::parse('2022-06-19 12:00');
//        $event->endDateTime = Carbon::parse('2022-06-19 13:00');
//        $event->location = '580 E 2Nd St, Unit 3, Boston, Massachusetts, Suffolk, 02127';
//        $event->colorId = 11;
//        $event->description = 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown';
//        $event->addAttendee(['email' => 'safayet.hoque@gmail.com']);
//        $event->save();
//
//        return \response()->json(['message' => 'success']);

        //Event::quickCreate('Appointment at Somewhere on July 1 10am-10:25am');
    }

    public function storeAdminReportPreparation(Request $request, $id) {
        logger("hello from storeAdminReportPreparation");
        logger($request->all());
        $report = OrderWReport::where('order_id', $id)->first();
        if($report){
            $report->reviewed_by = $request->reviewed_by;
            $report->creator_id = $request->creator_id;
            $report->save();
            return response()->json(['message' => 'Report updated successfully']);
        }
        $new = new OrderWReport();
        $new->order_id = $id;
        $new->reviewed_by = $request->reviewed_by;
        $new->creator_id = $request->creator_id;
        $new->created_by = auth()->user()->id;
        $new->save();

        return response()->json(['message' => 'Report created successfully']);
    
    }

    public function storeAssigneeReportPreparation(Request $request, $id) {
        logger("hello from storeAssigneeReportPreparation");
        logger($request->all());
        $report = OrderWReport::where('order_id', $id)->first();
        if($report){
            $report->assigned_to = $request->assigned_to;
            $report->trainee_id = $request->trainee_id;
            $report->note = $request->note;
            $report->updated_by = auth()->user()->id;
            $report->save();
            return response()->json(['message' => 'Report updated successfully']);
        }

        return response()->json(['message' => 'Report not available']);
    
    }
}
