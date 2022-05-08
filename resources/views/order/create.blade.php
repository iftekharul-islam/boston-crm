@extends('layouts.app')

@section('content')
    <order-create :order-list='"{{ route('orders.index') }}"'></order-create>
@endsection
