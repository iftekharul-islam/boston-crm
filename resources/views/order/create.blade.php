@extends('layouts.app')

@section('content')
    <order-create
            :order-list="'{{ route('orders.index') }}'"
            :user_id="{{ $userID }}"
            :company="{{ $company }}"
            :system-order-no="'{{ $system_order_no }}'"
            :appraisal-users="{{ $appraisal_users }}"
            :appraisal-types="{{ $appraisal_types }}"
            :loan-types="{{ $loan_types }}"
            :amc-clients="{{ $amc_clients }}"
            :lender-clients="{{ $lender_clients }}"
            :property-types="{{ $property_types }}">
    </order-create>
@endsection
