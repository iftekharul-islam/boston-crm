<?php

namespace App\Mail;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyOrderReport extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dataExist = false;
        $total_to_be_scheduled = 0;
        $to_be_scheduled_data = [];

        $total_scheduled = 0;
        $scheduled_data = [];

        $total_rescheduled = 0;
        $rescheduled_data = [];

        $total_inspected = 0;
        $inspected_data = [];

        $total_preparation = 0;
        $preparation_data = [];

        $total_review = 0;
        $review_data = [];

        $total_upload = 0;
        $upload_data = [];

        $total_rewrite = 0;
        $rewrite_data = [];

        $total_under_rewrite = 0;
        $under_rewrite_data = [];

        $total_analysis = 0;
        $analysis_data = [];

        $total_quality = 0;
        $quality_data = [];

        $total_submission = 0;
        $submission_data = [];

        $total_correction = 0;
        $correction_data = [];

        $total_delivery = 0;
        $delivery_data = [];

        $total_cancel = 0;
        $cancel_data = [];

        $total_delete = 0;
        $delete_data = [];

        $total_declined = 0;
        $declined_data = [];

        $total_cancel_with_payment = 0;
        $cancel_with_payment_data = [];

        $total_cancel_without_payment = 0;
        $cancel_without_payment_data = [];

        $total_on_hold = 0;
        $on_hold_data = [];

        $total_re_active = 0;
        $re_active_data = [];


        $data = Order::with('lender')->get();
        foreach($data as $item){
            if($item->status === 0){
                $dataExist = true;
                $total_to_be_scheduled ++;
                $to_be_scheduled_data[] = $this->dataByStatus($item);
            }
            if($item->status === 1){
                $dataExist = true;
                $total_scheduled ++;
                $scheduled_data[] = $this->dataByStatus($item);
            }
            if($item->status === 2){
                $dataExist = true;
                $total_rescheduled ++;
                $rescheduled_data[] = $this->dataByStatus($item);
            }
            if($item->status === 2){
                $dataExist = true;
                $total_inspected ++;
                $inspected_data[] = $this->dataByStatus($item);
            }
            if($item->status === 3){
                $dataExist = true;
                $total_inspected ++;
                $inspected_data[] = $this->dataByStatus($item);
            }
            if($item->status === 4){
                $dataExist = true;
                $total_preparation ++;
                $preparation_data[] = $this->dataByStatus($item);
            }
            if($item->status === 5){
                $dataExist = true;
                $total_review ++;
                $review_data[] = $this->dataByStatus($item);
            }
            if($item->status === 6){
                $dataExist = true;
                $total_upload ++;
                $upload_data[] = $this->dataByStatus($item);
            }

            if($item->status === 7){
                $dataExist = true;
                $total_rewrite ++;
                $rewrite_data[] = $this->dataByStatus($item);
            }
            if($item->status === 8){
                $dataExist = true;
                $total_under_rewrite ++;
                $under_rewrite_data[] = $this->dataByStatus($item);
            }
            if($item->status === 9){
                $dataExist = true;
                $total_analysis ++;
                $analysis_data[] = $this->dataByStatus($item);
            }
            if($item->status === 10){
                $dataExist = true;
                $total_quality ++;
                $quality_data[] = $this->dataByStatus($item);
            }
            if($item->status === 11){
                $dataExist = true;
                $total_submission ++;
                $submission_data[] = $this->dataByStatus($item);
            }
            if($item->status === 12){
                $dataExist = true;
                $total_correction ++;
                $correction_data[] = $this->dataByStatus($item);
            }
            if($item->status === 13){
                $dataExist = true;
                $total_delivery ++;
                $delivery_data[] = $this->dataByStatus($item);
            }
            if($item->status === 14){
                $dataExist = true;
                $total_cancel ++;
                $cancel_data[] = $this->dataByStatus($item);
            }
            if($item->status === 15){
                $dataExist = true;
                $total_delete ++;
                $delete_data[] = $this->dataByStatus($item);
            }
            if($item->status === 16){
                $dataExist = true;
                $total_declined ++;
                $declined_data[] = $this->dataByStatus($item);
            }
            if($item->status === 17){
                $dataExist = true;
                $total_cancel_with_payment ++;
                $cancel_with_payment_data[] = $this->dataByStatus($item);
            }
            if($item->status === 18){
                $dataExist = true;
                $total_cancel_without_payment ++;
                $cancel_without_payment_data[] = $this->dataByStatus($item);
            }
            if($item->status === 19){
                $dataExist = true;
                $total_on_hold ++;
                $on_hold_data[] = $this->dataByStatus($item);
            }

            if($item->status === 20){
                $dataExist = true;
                $total_re_active ++;
                $re_active_data[] = $this->dataByStatus($item);
            }
        }
        $order['to_be_scheduled']= [
            'name' => 'To be scheduled',
            'total' => $total_to_be_scheduled,
            'status' => 0,
            'data' => $to_be_scheduled_data
        ];
        $order['scheduled']= [
            'name' => 'Scheduled',
            'total' => $total_scheduled,
            'status' => 1,
            'data' => $scheduled_data
        ];
        $order['rescheduled']= [
            'name' => 'Rescheduled',
            'total' => $total_rescheduled,
            'status' => 2,
            'data' => $rescheduled_data
        ];
        $order['inspected']= [
            'name' => 'Inspected',
            'total' => $total_inspected,
            'status' => 3,
            'data' => $inspected_data
        ];

        $order['preparation']= [
            'name' => 'Report Preparation & Initial Review',
            'total' => $total_preparation,
            'status' => 4,
            'data' => $preparation_data
        ];

        $order['review']= [
            'name' => 'Ready for Analysis and Review',
            'total' => $total_review,
            'status' => 5,
            'data' => $review_data
        ];

        $order['upload']= [
            'name' => 'Check and Upload',
            'total' => $total_upload,
            'status' => 6,
            'data' => $upload_data
        ];

        $order['rewrite']= [
            'name' => 'Rewrite',
            'total' => $total_rewrite,
            'status' => 7,
            'data' => $rewrite_data
        ];

        $order['under_rewrite']= [
            'name' => 'Under Rewriting',
            'total' => $total_under_rewrite,
            'status' => 8,
            'data' => $under_rewrite_data
        ];
        $order['analysis']= [
            'name' => 'Ready for Analysis and Review',
            'total' => $total_analysis,
            'status' => 9,
            'data' => $analysis_data
        ];
        $order['quality']= [
            'name' => 'Under Quality Assurance (E&O)',
            'total' => $total_submission,
            'status' => 10,
            'data' => $submission_data
        ];
        $order['submission']= [
            'name' => 'Ready for Submission/Delivery',
            'total' => $total_submission,
            'status' => 11,
            'data' => $submission_data
        ];
        $order['correction']= [
            'name' => 'Ready for Submission/Delivery',
            'total' => $total_correction,
            'status' => 12,
            'data' => $correction_data
        ];
        $order['delivery']= [
            'name' => 'Delivered',
            'total' => $total_delivery,
            'status' => 13,
            'data' => $delivery_data
        ];
        $order['cancel']= [
            'name' => 'Cancelled',
            'total' => $total_cancel,
            'status' => 14,
            'data' => $cancel_data
        ];
        $order['delete']= [
            'name' => 'Deleted',
            'total' => $total_delete,
            'status' => 15,
            'data' => $delete_data
        ];
        $order['declined']= [
            'name' => 'Declined',
            'total' => $total_declined,
            'status' => 16,
            'data' => $delete_data
        ];
        $order['cancel_with_payment']= [
            'name' => 'Cancel With Payment',
            'total' => $total_cancel_with_payment,
            'status' => 17,
            'data' => $cancel_with_payment_data
        ];
        $order['cancel_without_payment']= [
            'name' => 'Cancel Without Payment',
            'total' => $total_cancel_without_payment,
            'status' => 18,
            'data' => $cancel_without_payment_data
        ];
        $order['on_hold']= [
            'name' => 'On Hold',
            'total' => $total_on_hold,
            'status' => 19,
            'data' => $on_hold_data
        ];
        $order['re_active']= [
            'name' => 'Re-Active',
            'total' => $total_re_active,
            'status' => 20,
            'data' => $re_active_data
        ];


        logger($order);
        logger('hello from mail');
        return $this->view('emails.daily-report', [
            'order' => $order,
            'name' => $this->name,
            'dataExists' =>  $dataExist,
            'date' => Carbon::today()->format('d M Y')
            ]
        );
    }

    public function dataByStatus($item)
    {
        return [
            'order_no' => $item->system_order_no,
            'name' => $item->lender->name,
            'address' => $item->lender->address,
        ];
    }
}
