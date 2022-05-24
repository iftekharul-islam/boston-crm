@extends('layouts.app')
@section('content')
    <div class="user-registration bg-login-box">
        <div class=" max-w-1576 mx-auto">
            <div class="user-registration-logo d-flex align-items-center mgb-48">
                <img src="{{ asset('img/boston-black.png') }}" alt="logo" class="img-fluid">
                <div class="mgl-20">
                    <h4 class="fs-34 fw-bold mgb-12">Boston Appraisal Services</h4>
                    <a href="/" class="text-light-black mb-0">www.bostonappraisal.com</a>
                </div>
            </div>
            <h4 class="text-light-black fs-20 mb-3 text-600">{{ $order->system_order_no }} require some files</h4>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('order.file.upload', request()->route('id') ) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="user-registration__box bg-white br-8 pdt-32">
                    <div class="pdl-32">
                        <p class="fs-20 text-600 text-light-black mb-3">Upload Order Files </p>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="file_type">
                            <option> Select a type</option>
                            @foreach($order_types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="file" name="files[]" multiple>
                    </div>
                    <div class="py-3 bg-platinum d-flex justify-content-end px-3 box-footer">
                        <button class="button button-primary px-5">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
