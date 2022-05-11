@extends('layouts.app')

@section('content')
    <order-create
            :order-list="'{{ route('orders.index') }}'"
            :system-order-no="'{{ $system_order_no }}'"
            :appraisal-users="{{ $appraisal_users }}"
            :appraisal-types="{{ $appraisal_types }}"
            :loan-types="{{ $loan_types }}">
    </order-create>
@endsection
