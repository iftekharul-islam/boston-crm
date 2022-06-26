@extends('layouts.app')

@section('content')
    <order-edit-vue :order="{{ $order }}"
                :order-list="'{{ route('orders.index') }}'"
                :user_id="{{ $userID }}"
                :appraisal-users="{{ $appraisal_users }}"
                :appraisal-types="{{ $appraisal_types }}"
                :loan-types="{{ $loan_types }}"
                :amc-clients="{{ $amc_clients }}"
                :lender-clients="{{ $lender_clients }}"
                :company="{{ $company }}"
                :property-types="{{ $property_types }}"/>
@endsection
