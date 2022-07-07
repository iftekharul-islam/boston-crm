@extends('layouts.app')
@section('content')
    <div class="order bg-platinum dashboard-space">
        <order-list :filter-type="{{ json_encode($filterType) }}" :summaryData="{{ json_encode($orderSummary) }}" :data="{{ json_encode($orderData) }}"></order-list>
    </div>
@endsection
