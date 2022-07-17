<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\SentMessage;

class CallService
{
    public function sendMessage($data)
    {
        $order = Order::find($data['order_id']);
        if ($data['send_email'] == 1) {
            foreach ($data['emails'] as $email) {
                $this->sendEmail($email, $data['message'], $data['subject']);
            }
        }
        if ($data['send_sms']  == 1) {
            foreach ($data['phones'] as $phone) {
                $formatted_number = "1" . (int) str_replace('-', '', $phone);
                $this->sendSms($order->system_order_no, $formatted_number, $data['message']);
            }
        }
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
                'destination' => "+8801837487415",
                'text' => "Hello,
“LENDER NAME” assigned us an appraisal for the property “SUBJECT FULL ADDRESS”. Please contact us to schedule an appointment at 617-440-7700 or orders@bostonappraisal.com.
Thank you",
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
