@extends('layouts.app')
@section('content')
    <div class="order bg-platinum dashboard-space">
        <order-list :summary="{{ json_encode($orderSummary) }}" :data="{{ json_encode($orderData) }}"></order-list>
    </div>
@endsection
