<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function store(Request $get) {
        $step1 = $get->step1;
        $step2 = $get->step2;

        $amcClient = $step['amcClient'];
        $appraiserName = $step['appraiserName'];
        $appraiserType = $step['appraiserType'];
        $city = $step['city'];
        $clientOrderNo = $step['clientOrderNo'];
        $country = $step['country'];
        $dueDate = $step['dueDate'];
        $fee = $step['fee'];
        $fhaCaseNo = $step['fhaCaseNo'];
        $lender = $step['lender'];
        $loanNo = $step['loanNo'];
        $loanType = $step['loanType'];
        $note = $step['note'];
        $receiveDate = $step['receiveDate'];
        $searchAddress = $step['searchAddress'];
        $state = $step['state'];
        $street = $step['street'];
        $systemOrder = $step['systemOrder'];
        $technologyFee = $step['technologyFee'];
        $unitNo = $step['unitNo'];
        $zipcode = $step['zipcode'];

        $borrower_contact = $step2['borrower_contact'];
        $borrower_contact_s = $step2['borrower_contact_s'];
        $borrower_email = $step2['borrower_email'];
        $borrower_email_s = $step2['borrower_email_s'];
        $borrower_name = $step2['borrower_name'];
        $co_borrower_name = $step2['co_borrower_name'];
        $contactSame = $step2['contactSame'];
        $contact_info = $step2['contact_info'];
        $contact_number = $step2['contact_number'];
        $contact_number_s = $step2['contact_number_s'];
        $email_address = $step2['email_address'];
        $email_address_s = $step2['email_address_s'];
    }
}
