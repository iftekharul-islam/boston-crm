<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\ContactInfo;
use App\Models\BorrowerInfo;
use App\Models\PropertyInfo;
use Illuminate\Http\Request;
use App\Models\AppraisalDetail;
use App\Models\ProvidedService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    public function store(Request $get) {
        $step = $get->step1;
        $step2 = $get->step2;
        $company = $get->company;

        $errorChecking = $this->getErrorMessage($get);
        $error = $errorChecking['error'];
        $errorMessage = $errorChecking['message'];
        if ($error == true) {
            return response()->json(['error' => $error, 'messages' => $errorMessage]);
        }
        
        $orderProccess = DB::transaction( function() use ($step, $step2, $company, $get) {
            $amcClient = $step['amcClient'];
            $appraiserName = $step['appraiserName'];
            
            $dueDate = $step['dueDate'];
            $receiveDate = $step['receiveDate'];
            $systemOrder = $step['systemOrder'];
            $clientOrderNo = $step['clientOrderNo'];
            $lender = $step['lender'];


            $user = User::find($get->user_id);
            // creating orders
            $order = new Order;
            $order->amc_id = $amcClient;
            $order->lender_id = $lender;
            $order->company_id = $company['id'];
            $order->status = 1;
            $order->created_by = $user->id;
            $order->received_date = $dueDate;
            $order->due_date = $receiveDate;
            $order->client_order_no = $clientOrderNo;
            $order->system_order_no = "BAS-".uniqid();
            $order->created_at = Carbon::now();
            $order->save();


            $fhaCaseNo = $step['fhaCaseNo'];
            $loanNo = $step['loanNo'];
            $technologyFee = $step['technologyFee'];
            $loanType = $step['loanType'];

            // Create appraisal details
            $apprlDetails = new AppraisalDetail;
            $apprlDetails->appraiser_id = $appraiserName;
            $apprlDetails->order_id = $order->id;
            $apprlDetails->loan_no = $loanNo;
            $apprlDetails->loan_type = $loanType;
            $apprlDetails->technology_fee = $technologyFee;
            $apprlDetails->fha_case_no = $fhaCaseNo;
            $apprlDetails->created_at = Carbon::now();
            $apprlDetails->save();

            // Create Provider Types
            $appraiserType = $step['appraiserType'];
            $fee = $step['fee'];
            $note = $step['note'];

            $providerType = new ProvidedService;
            $providerType->order_id = $order->id;
            $providerType->appraiser_type_fee = json_encode($fee);
            $providerType->note = $note;
            $providerType->total_fee = collect($fee)->sum('fee');
            $providerType->created_at = Carbon::now();
            $providerType->save();

            $searchAddress = $step['searchAddress'];
            $state = $step['state'];
            $street = $step['street'];
            $unitNo = $step['unitNo'];
            $zipcode = $step['zipcode'];
            $city = $step['city'];
            $country = $step['country'];

            // create property info
            $propertyInfo = new PropertyInfo;
            $propertyInfo->order_id = $order->id;
            $propertyInfo->search_address = $searchAddress;
            $propertyInfo->street_name = $street;
            $propertyInfo->city_name = $city;
            $propertyInfo->state_name = $state;
            $propertyInfo->zip = $zipcode;
            $propertyInfo->country = $country;
            $propertyInfo->unit_no = $unitNo;
            $propertyInfo->latitude = "1";
            $propertyInfo->longitude = "1";
            $propertyInfo->created_at = Carbon::now();
            $propertyInfo->save();


            $borrower_contact = $step2['borrower_contact'];
            $borrower_contact_s = $step2['borrower_contact_s'];
            $borrower_email = $step2['borrower_email'];
            $borrower_email_s = $step2['borrower_email_s'];
            $borrower_name = $step2['borrower_name'];
            $co_borrower_name = $step2['co_borrower_name'];
            // create borrower type
            $borrowerType = new BorrowerInfo;
            $borrowerType->order_id = $order->id; 
            $borrowerType->borrower_name = $borrower_name;
            $borrowerType->co_borrower_name = $co_borrower_name;
            $borrowerType->contact_email = json_encode([
                'email' => $borrower_email_s,
                'phone' => $borrower_contact_s
            ]);
            $borrowerType->created_at = Carbon::now();
            $borrowerType->save();


            // Contact Info Saved
            $contactSame = $step2['contactSame'];
            $contact_info = $step2['contact_info'];
            $contact_number = $step2['contact_number'];
            $contact_number_s = $step2['contact_number_s'];
            $email_address = $step2['email_address'];
            $email_address_s = $step2['email_address_s'];

            $contactInfo = new ContactInfo;
            $contactInfo->order_id = $order->id;
            $contactInfo->is_borrower = $contactSame == 1 ? 1 : 0;
            $contactInfo->contact = $contact_info;
            $contactInfo->contact_email = json_encode([
                'email' => $email_address_s,
                'phone' => $contact_number_s
            ]);
            $contactInfo->created_at = Carbon::now();
            $contactInfo->save();

            return response()->json([
                "error" => false,
                "message" => "New order has been stored"
            ]);
        });
        return $orderProccess;
    }

    protected function getErrorMessage($get) {
        $step = $get->step1;
        $step2 = $get->step2;
        $company = $get->company;

        $error = false;
        $errorMessage = [
            'step1' => [],
            'step2' => []
        ];

        if (!isset($company['id'])) {
            $error = true;
            array_push($errorMessage['step1'], 'Company Information Missing');
        }

        $array_filter = [
            "clientOrderNo",
            "loanNo",
            "loanType",
            "receiveDate",
            "fhaCaseNo",
            "appraiserName",
            "dueDate",
            "amcClient",
            "lender",
            "note",
            "searchAddress",
            "state",
            "city",
            "street",
            "zipcode",
            "country",
        ];

        foreach ($array_filter as $item) {
            if ($step[$item] == null) {
                $error = true;
                array_push($errorMessage['step1'], $this->recTitle($item)." is missing");
            }
        }

        $array_filter2 = [
            "borrower_name",
            "co_borrower_name"
        ];

        foreach ($array_filter2 as $item) {
            if ($step2[$item] == null) {
                $error = true;
                array_push($errorMessage['step2'], $this->recTitle($item)." is missing");
            }
        }
        if ($step2['borrower_contact'] == false) {
            $error = true;
            array_push($errorMessage['step2'], $this->recTitle('borrower_contact')." is missing");
        }
        if ($step2['borrower_email'] == false) {
            $error = true;
            array_push($errorMessage['step2'], $this->recTitle('borrower_email')." is missing");
        }


        if ($step2['contactSame'] == 1) {
            $array_filter3 = [
                "contact_info",
                "contact_number",
                "email_address"
            ];
            foreach ($array_filter3 as $item) {
                if ($step2[$item] == null) {
                    $error = true;
                    array_push($errorMessage['step2'], $this->recTitle($item)." is missing");
                }
            }
        }

        return [
            "error" => $error,
            "message" => $errorMessage,
        ];
    }

    protected function recTitle($item) {
        return ucwords(str_replace("_", " ", $item));
    }

}
