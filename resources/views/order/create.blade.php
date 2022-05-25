@extends('layouts.app')

@section('content')
    <order-create
            :order-list="'{{ route('orders.index') }}'"
            :system-order-no="'{{ $system_order_no }}'"
            :appraisal-users="{{ $appraisal_users }}"
            :appraisal-types="{{ $appraisal_types }}"
            :company="{{ $company }}"
            :user_id="{{ $userID }}"
            :loan-types="{{ $loan_types }}"
            :amc-clients="{{ $amc_clients }}"
            :lender-clients="{{ $lender_clients }}">
    </order-create>
@endsection
