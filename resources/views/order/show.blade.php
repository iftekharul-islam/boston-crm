@extends('layouts.app')
@section('content')
    <div class="order-details bg-platinum dashboard-space">
        <a href="{{ url('/orders') }}" class="text-light-black d-inline-flex align-items-center mgb-20">
            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.57086 5.18001C9.76086 5.18001 9.95086 5.25 10.1009 5.4C10.3909 5.69 10.3909 6.17 10.1009 6.46L4.56086 12L10.1009 17.54C10.3909 17.83 10.3909 18.31 10.1009 18.6C9.81086 18.89 9.33086 18.89 9.04086 18.6L2.97086 12.53C2.68086 12.24 2.68086 11.76 2.97086 11.47L9.04086 5.4C9.19086 5.25 9.38086 5.18 9.57086 5.18001Z"
                      fill="#2F415E"/>
                <path d="M3.67 11.25L20.5 11.25C20.91 11.25 21.25 11.59 21.25 12C21.25 12.41 20.91 12.75 20.5 12.75L3.67 12.75C3.26 12.75 2.92 12.41 2.92 12C2.92 11.59 3.26 11.25 3.67 11.25Z"
                      fill="#2F415E"/>
            </svg>
            Back to order list</a>
        @php $order_id = request()->route('id') @endphp


        {{-- header --}}
        <order-header :order="{{ $order }}" :share-url="'{{ url('/public-order/'. base64_encode($order_id) ) }}'" :diff_in_days="{{ $diff_in_days }}" :diff_in_hours="{{ $diff_in_hours }}"></order-header>
        <div class="order-details-box-main row">
            <div class="order-details__left col-md-6">
                {{-- Basic Information --}}
                <basic-info :order="{{ $order }}"  :order-id="'{{ $order_id }}'"></basic-info>
                {{-- Property Info --}}
                <property-info :order="{{ $order }}"  :order-id="'{{ $order_id }}'"></property-info>
                {{-- Borrower --}}
                <borrower :order="{{ $order }}"  :order-id="'{{ $order_id }}'"></borrower>
                {{-- Contact --}}
                <contact :order="{{ $order }}"  :order-id="'{{ $order_id }}'"></contact>
                {{-- Inspection --}}
                <inspection :order="{{ $order }}"  :order-id="'{{ $order_id }}'"></inspection>
                {{-- Issues --}}
                <issues></issues>
            </div>
            <div class="order-details__right col-md-6">
                {{-- Appraisal Details --}}
                <appraisal-details :order="{{ $order }}" :appraisers="{{ $appraisers }}" :loan-types="{{ $loan_types }}" :order-id="'{{ $order_id }}'"></appraisal-details>
                {{-- Provided Services --}}
                <provided-services :order="{{ $order }}" :appraisal-types="{{ $appraisal_types }}" :order-id="'{{ $order_id }}'"></provided-services>
                {{-- Client --}}
                <client-info :order="{{ $order }}" :all-amc="{{ $all_amc }}" :all-lender="{{ $all_lender }}" :order-id="'{{ $order_id }}'"></client-info>
                {{-- Call log --}}
                <call-log :order="{{ $order }}"></call-log>
                {{-- Map --}}
                <map-view :order="{{ $order }}"></map-view>
            </div>
        </div>
        <div class="row">
            <workflow :order="{{ $order }}"></workflow>
            <history :order="{{ $order }}"></history>
        </div>
        <div class="mgt-32">
            <files :order-files="{{ json_encode($order_files) }}" :order-id="'{{ $order_id }}'" :order-file-types="{{ json_encode($order_file_types) }}"></files>
        </div>

        <div class="note-grid">
             {{-- Invoice --}}
             <invoice :order="{{ $order }}"></invoice>
             {{-- Note --}}
             <notes :order="{{ $order }}"></notes>
            {{-- Activity log --}}
            <activity-log :order="{{ $order }}" :order-id="'{{ $order_id }}'"></activity-log>
            {{-- <div class="row">
                <div class="col-md-12">

                </div>
                <div class="col-md-12">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                </div>
            </div> --}}
        </div>
    </div>
@endsection


@section("js")

<script>
    $(document).on("click", ".order-details-box .box-header", function(e){
        let body = $(this).parent().find('.box-body');
        let target = $(e.target);
        let targetA = $("a.edit");

        if ( !target.is(targetA)) {
            if (body.is(":visible")) {
                body.slideUp();
            } else {
                body.slideDown();
            }
        }
    });
    $(".alert-message").delay(4000).fadeOut(1000);
</script>
@endsection


@section("css")
<style>
    .order-details-box .box-header{
        cursor: pointer;
    }
    .list-items span {
        border: thin solid #cfcfcf;
        padding: 2px 10px;
        border-radius: 0.25rem;
        background: #efefef;
        margin: 0;
        margin-right: 8px;
        display: inline-block;
        cursor: pointer;
    }
</style>
@endsection
