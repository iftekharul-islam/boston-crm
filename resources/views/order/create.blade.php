@extends('layouts.app')

@section('content')
{{--    {{ dd($system_order_no) }}--}}
    <order-create :order-list="'{{ route('orders.index') }}'" :system-order-no="'{{ $system_order_no }}'"></order-create>
@endsection
