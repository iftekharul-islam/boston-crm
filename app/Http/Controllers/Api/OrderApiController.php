<?php

namespace App\Http\Controllers\Api;

use App\Models\LoanType;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Helpers\CrmHelper;
use App\Models\ActivityLog;
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
    use CrmHelper;

    public function store(Request $get)
    {

        $step = $get->step1;
        $step2 = $get->step2;
        $company = $get->company;

        $errorChecking = $this->getErrorMessage($get);
        $error = $errorChecking['error'];
        $errorMessage = $errorChecking['message'];

        if ($error == true) {
            return response()->json(['error' => $error, 'messages' => $errorMessage]);
        }

        $orderProccess = DB::transaction(function () use ($step, $step2, $company, $get) {
            $amcClient = $step['amcClient'];
            $appraiserName = $step['appraiserName'];

            try {
                $dueDate = Carbon::parse($step['dueDate']);
                $receiveDate = Carbon::parse($step['receiveDate']);
            } catch (\Exception $e) {
                return response()->json(['error' => false, 'messages' => ['Please check received & due dates']]);
            }

            $systemOrder = $step['systemOrder'];
            $clientOrderNo = $step['clientOrderNo'];
            $lender = $step['lender'];

            $amcClient = isset($amcClient['id']) ? $amcClient['id'] : $amcClient;
            $lender = isset($lender['id']) ? $lender['id'] : $lender;

            $user = User::find($get->user_id);
            $submitType = $get->type;
            $orderId = null;
            if ($submitType) {
                $orderId = $get->order['id'];
            } else {
                $oldOrder = Order::where('client_order_no', $clientOrderNo)->first();
                if ($oldOrder) {
                    return response()->json(['error' => true, 'submit' => true, 'messages' => 'Client order number already exists. Please change client order number on step 1']);
                }
            }


            if ($orderId == null) {
                $order = new Order;
                $order->created_at = Carbon::now();
                $order->status = 0;
            } else {
                $order = Order::find($orderId);
                if (!$order) {
                    return response()->json(['error' => true, 'messages' => ['Order information not found']]);
                }
                $order->updated_at = Carbon::now();
            }

            // dd($this->getSystemOrderNumber());
            $systemOrder = $systemOrder ? $systemOrder : $this->getSystemOrderNumber();
            // creating orders
            $order->amc_id = $amcClient;
            $order->lender_id = $lender;
            $order->company_id = $company['id'];
            $order->rush = $step2['rush'] ? 1 : 0;
            $order->created_by = $user->id;
            $order->received_date = $receiveDate;
            $order->due_date = $dueDate;
            $order->client_order_no = $clientOrderNo;
            $order->system_order_no = $systemOrder;
            $order->workflow_status = json_encode($order->workflow_steps);
            // return $order;
            $order->save();

            if ($orderId == null) {
                $this->addHistory($order, $user, "New order has been created by {$user->name}", 'order-create');
            }

            $fhaCaseNo = $step['fhaCaseNo'];
            $propertyType = $step['propertyType'];
            $loanNo = $step['loanNo'];
            $technologyFee = $step['technologyFee'];
            $loanType = $step['loanType'];

            // Create appraisal details

            if ($orderId == null) {
                $apprlDetails = new AppraisalDetail;
                $apprlDetails->created_at = Carbon::now();
            } else {
                $apprlDetails = AppraisalDetail::where('order_id', $order->id)->first();
                if (!$apprlDetails) {
                    return response()->json(['error' => true, 'messages' => ['Order information not found']]);
                }
                $apprlDetails->updated_at = Carbon::now();
            }

            $appraiserName = isset($appraiserName['id']) ? $appraiserName['id'] : $appraiserName;

            $apprlDetails->appraiser_id = $appraiserName;
            $apprlDetails->order_id = $order->id;
            $apprlDetails->loan_no = $loanNo;
            $apprlDetails->loan_type = isset($loanType['id']) ? $loanType['id'] : $loanType;
            $apprlDetails->technology_fee = $technologyFee;
            $apprlDetails->fha_case_no = $fhaCaseNo;
            $apprlDetails->property_type = $propertyType;
            $apprlDetails->save();


            // Create Provider Types
            $fee = $get->providedData['extra'];
            $note = $step['note'];


            if ($orderId == null) {
                $providerType = new ProvidedService;
                $providerType->created_at = Carbon::now();
            } else {
                $providerType = ProvidedService::where('order_id', $order->id)->first();
                if (!$providerType) {
                    return response()->json(['error' => true, 'messages' => ['Order information not found']]);
                }
                $providerType->updated_at = Carbon::now();
            }

            $providerType->order_id = $order->id;
            $providerType->appraiser_type_fee = json_encode($fee);
            $providerType->note = $note;
            $providerType->total_fee = collect($fee)->sum('fee');
            $providerType->save();


            $searchAddress = $step['searchAddress'];
            $formatedAddress = $step['formatedAddress'] ?? $searchAddress;
            $state = $step['state'];
            $street = $step['street'];
            $unitNo = $step['unitNo'];
            $zipcode = $step['zipcode'];
            $city = $step['city'];
            $country = $step['country'];
            $county = $step['county'];
            $latitude = $step['lat'];
            $longitude = $step['lng'];

            // create property info

            if ($orderId == null) {
                $propertyInfo = new PropertyInfo;
                $propertyInfo->created_at = Carbon::now();
            } else {
                $propertyInfo = PropertyInfo::where('order_id', $order->id)->first();
                if (!$propertyInfo) {
                    return response()->json(['error' => true, 'messages' => ['Order information not found']]);
                }
                $propertyInfo->updated_at = Carbon::now();
            }

            $propertyInfo->order_id = $order->id;
            $propertyInfo->search_address = $searchAddress;
            $propertyInfo->formatedAddress = $formatedAddress;
            $propertyInfo->street_name = $street;
            $propertyInfo->city_name = $city;
            $propertyInfo->state_name = $state;
            $propertyInfo->zip = $zipcode;
            $propertyInfo->country = $country;
            $propertyInfo->county = $county;
            $propertyInfo->unit_no = $unitNo;
            $propertyInfo->latitude = $latitude;
            $propertyInfo->longitude = $longitude;
            $propertyInfo->save();


            $borrower_contact = $step2['borrower_contact'];
            $borrower_contact_s = $step2['borrower_contact_s'];
            $borrower_email = $step2['borrower_email'];
            $borrower_email_s = $step2['borrower_email_s'];
            $borrower_name = $step2['borrower_name'];
            $co_borrower_name = $step2['co_borrower_name'];


            // create borrower type
            if ($orderId == null) {
                $borrowerType = new BorrowerInfo;
                $borrowerType->created_at = Carbon::now();
            } else {
                $borrowerType = BorrowerInfo::where('order_id', $order->id)->first();
                if (!$borrowerType) {
                    return response()->json(['error' => true, 'messages' => ['Order information not found']]);
                }
                $borrowerType->updated_at = Carbon::now();
            }
            $borrowerType->order_id = $order->id;
            $borrowerType->borrower_name = $borrower_name;
            $borrowerType->co_borrower_name = $co_borrower_name;
            $borrowerType->contact_email = json_encode([
                'email' => $borrower_email_s,
                'phone' => $borrower_contact_s
            ]);
            $borrowerType->save();


            // Contact Info Saved
            $contactSame = $step2['contactSame'];
            $contact_info = $step2['contact_info'];
            $contact_number = $step2['contact_number'];
            $contact_number_s = $step2['contact_number_s'];
            $email_address = $step2['email_address'];
            $email_address_s = $step2['email_address_s'];

            if ($orderId == null) {
                $contactInfo = new ContactInfo;
                $contactInfo->created_at = Carbon::now();
            } else {
                $contactInfo = ContactInfo::where('order_id', $order->id)->first();
                if (!$contactInfo) {
                    return response()->json(['error' => true, 'messages' => ['Order information not found']]);
                }
                $contactInfo->updated_at = Carbon::now();
            }

            $contactInfo->order_id = $order->id;
            $contactInfo->is_borrower = $contactSame == 1 ? 1 : 0;
            $contactInfo->contact = $contactSame == 1 ? $borrower_name : $contact_info;
            $contactInfo->contact_email = json_encode([
                'email' => $contactSame == 1 ? $borrower_email_s : $email_address_s,
                'phone' => $contactSame == 1 ? $borrower_contact_s : $contact_number_s
            ]);
            $contactInfo->save();

            //file upload
            if (isset($step2["file"])) {
                $file = $step2["file"];
                $order->addMediaFromBase64($file)
                    ->withCustomProperties(['type' => 'Order','user'=> auth()->user->name])
                    ->toMediaCollection('orders');
            }

            if ($orderId == null) {
                $message = "New order has been stored";
            } else {
                $message = "Order {$order->system_order_no} has been updated";
            }

            $data = [
                "activity_text" => $message,
                "activity_by" => $user->id,
                "order_id" => $order->id
            ];
            ActivityLog::create($data);

            return response()->json([
                "error" => false,
                "orderId" => $order->id,
                "message" => $message
            ]);
        });
        return $orderProccess;
    }

    protected function getErrorMessage($get)
    {
        $step = $get->step1;
        $step2 = $get->step2;
        $company = $get->company;
        $providedData = $get->providedData;

        $error = false;
        $errorMessage = [
            'step1' => [],
            'step2' => []
        ];

        if (!isset($company['id'])) {
            $error = true;
            array_push($errorMessage['step1'], 'Company Information Missing');
        }

        if (!isset($providedData['extra']) || isset($providedData['extra']) && count($providedData['extra']) == 0) {
            $error = true;
            array_push($errorMessage['step1'], 'Please add provider services data');
        }

        $array_filter = [
            "clientOrderNo",
            // "loanNo",
            "loanType",
            "receiveDate",
            "fhaCaseNo",
            "appraiserName",
            "dueDate",
            "amcClient",
            "lender",
            // "note",
            "searchAddress",
            "state",
            "city",
            "street",
            "zipcode",
            "country",
            'county',
            "lat",
            "lng",
        ];

        foreach ($array_filter as $item) {
            if ($item == 'fhaCaseNo') {
                $loanType = LoanType::where('id', $step['loanType'])->first();
                if ($loanType && $loanType->is_fha) {
                    if ($step[$item] == null) {
                        $error = true;
                        array_push($errorMessage['step1'], $this->recTitle($item) . " is missing");
                    }
                }
            } elseif ($step[$item] == null) {
                $error = true;
                array_push($errorMessage['step1'], $this->recTitle($item) . " is missing");
            }
        }

        $array_filter2 = [
            "borrower_name",
            // "co_borrower_name"
        ];

        foreach ($array_filter2 as $item) {
            if ($step2[$item] == null) {
                $error = true;
                array_push($errorMessage['step2'], $this->recTitle($item) . " is missing");
            }
        }
        if ($step2['borrower_contact'] == false) {
            $error = true;
            array_push($errorMessage['step2'], $this->recTitle('borrower_contact') . " is missing");
        }
        if ($step2['borrower_email'] == false) {
            $error = true;
            array_push($errorMessage['step2'], $this->recTitle('borrower_email') . " is missing");
        }

        if ($step2['contactSame'] == 0) {
            $array_filter3 = [
                "contact_info",
                "contact_number",
                "email_address"
            ];
            foreach ($array_filter3 as $item) {
                if ($step2[$item] == null) {
                    $error = true;
                    array_push($errorMessage['step2'], $this->recTitle($item) . " is missing");
                }
            }
        }

        return [
            "error" => $error,
            "message" => $errorMessage,
        ];
    }

    protected function recTitle($item)
    {
        return ucwords(str_replace("_", " ", $item));
    }

    public function getSameData(Request $get)
    {
        $propertyInfo = PropertyInfo::where('street_name', "LIKE", "%$get->street%")->get()->pluck('order_id');
        $order = Order::whereIn('id', $propertyInfo)->orderBy('id', 'desc')->with(
            'amc',
            'lender',
            'user',
            'appraisalDetail',
            'providerService',
            'propertyInfo',
            'borrowerInfo',
            'contactInfo'
        )->get();
        return response()->json([
            'totalOrder' => $order->count(),
            'orders' => $order
        ]);
    }
}
