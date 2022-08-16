<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CallLog;
use App\Models\PropertyInfo;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;

class CallService
{
    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function sendMessage($data)
    {
        $value_of = $data["data"];
        $order = Order::find($value_of['order_id']);
        if ($value_of['send_email'] == 1) {
            foreach ($data['emails'] as $email) {
                $this->sendEmail($email['text'], $value_of['message'], $value_of['subject']);
            }
        }
        if ($value_of['send_sms']  == 1) {
            foreach ($data['phones'] as $phone) {
                $formatted_number = "1" . (int) str_replace('-', '', $phone['text']);
                $this->sendSms($order->system_order_no, $formatted_number, $value_of['message']);
            }
        }
        $log = new CallLog();
        $log->order_id = $order->id;
        $log->caller_id = Auth::id();
        $log->message = $value_of['message'];
        $log->save();

        $property_address = PropertyInfo::where('order_id', $order->id)->first();

        $msg = "A message has been sent to client. Property Address : " . $property_address->formatedAddress;

        $data = [
            "activity_text" => $msg,
            "activity_by" => Auth::id(),
            "order_id" => $order->id
        ];

        $this->repository->addActivity($data);
    }

    public function sendEmail($email, $description, $subject)
    {
        $data = array(
            'description' => $description,
        );
        Mail::send('emails.call-email', $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
            $message->from('order@bas-crm.com', 'Boston CRM');
        });
        return count(Mail::failures()) == 0 ? true : false;
    }


    public function sendSms($message_id, $destination, $message)
    {
        $token = 'rAe3Kosn4QnyEwCmEwZzsSBCSeydDmh2RnwlpfsEOTg';
        $url = 'https://sms.8x8.com/api/v1/subaccounts/BostonAppraisalServices_6qQ93_hq/messages';
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $response = Http::withHeaders($headers)
            ->withToken($token)
            ->post($url, [
                'source' => 'Boston CRM',
                'clientMessageId' => $message_id,
                'destination' => $destination,
                'text' => $message,
                "encoding" => "AUTO"
            ]);

        $result = $response->json();
        return $result && $result["status"]["code"] == "QUEUED" ? true : false;

        // $umid = $result['umid'];
        // $timestamp = time();
        // //feedback url for validating success or failure
        // $success_url = 'https://sms.8x8.com/api/v1/subaccounts/BostonAppraisalServices_6qQ93_hq/messages/' . $umid . '/feedback';

        // $success_response = Http::withHeaders($headers)
        //     ->withToken($token)
        //     ->post($success_url, [
        //         'outcome' => 'success', // success or failure ,required field
        //         'timestamp' => $timestamp
        //     ]);

        // dd($success_response->json());
    }
}
