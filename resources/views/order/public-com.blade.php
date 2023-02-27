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
        <h4 class="text-light-black fs-20 mb-3 text-600">{{ $order->system_order_no }} require some com files for
            following properties</h4>
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
        @endif
        <form id="public-order-form" action="{{ route('public.com.files', request()->route('id') ) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="user-registration__box bg-white br-8">
                <div class="p-4">
                    <h1 class="fs-20 text-600 text-light-black mb-3">Upload Com Files </h1>
                </div>
                @foreach($com_list as $key => $file)
                <div class="col-md-4 mb-4 p-4">
                    <label id="com-files text-large" class="mb-3"><b>{{ $file['address'] }}</b></label>
                    <input class="form-control" id="com-files" type="file" name="files-{{ $key }}[]" multiple>
                </div>
                @endforeach
                <div class="py-3 bg-platinum d-flex justify-content-end px-3 box-footer">
                    <button type="submit" class="submit button button-primary px-5">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">

</script>
@endpush
