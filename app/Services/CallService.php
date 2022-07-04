<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CallService
{
    public function sendMessage($data)
    {
        if ($data['send_email'] == 1) {
            return 0;
        } else if ($data['send_sms']  == 1) {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withToken('rAe3Kosn4QnyEwCmEwZzsSBCSeydDmh2RnwlpfsEOTg')
                ->post('https://sms.8x8.com/api/v1/subaccounts/BostonAppraisalServices_6qQ93_hq/messages', [
                    'source' => 'Boston CRM',
                    'clientMessageId' => "ORD-001",
                    'destination' => '+8801988812097',
                    'text' => 'Test',
                    "encoding" => "AUTO"
                ]);
            $result = $response->json();
            $umid = $result['umid'];
            $timestamp = $result['timestamp'];
            $success_url = 'https://sms.8x8.com/api/v1/subaccounts/BostonAppraisalServices_6qQ93_hq/messages/' . $umid .'/feedback';
            $success_response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->withToken('rAe3Kosn4QnyEwCmEwZzsSBCSeydDmh2RnwlpfsEOTg')
                ->post($success_url,[
                    'outcome' => 'success',
                    'timestamp' => $timestamp
                ]);
            dd($success_response->json());

        } else {
            return 0;
        }
    }
}
