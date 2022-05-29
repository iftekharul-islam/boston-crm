@extends('layouts.app')
@section('content')
    <div class="order-details bg-platinum dashboard-space">
        <a href="{{ url('/order') }}" class="text-light-black d-inline-flex align-items-center mgb-20">
            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.57086 5.18001C9.76086 5.18001 9.95086 5.25 10.1009 5.4C10.3909 5.69 10.3909 6.17 10.1009 6.46L4.56086 12L10.1009 17.54C10.3909 17.83 10.3909 18.31 10.1009 18.6C9.81086 18.89 9.33086 18.89 9.04086 18.6L2.97086 12.53C2.68086 12.24 2.68086 11.76 2.97086 11.47L9.04086 5.4C9.19086 5.25 9.38086 5.18 9.57086 5.18001Z"
                      fill="#2F415E"/>
                <path d="M3.67 11.25L20.5 11.25C20.91 11.25 21.25 11.59 21.25 12C21.25 12.41 20.91 12.75 20.5 12.75L3.67 12.75C3.26 12.75 2.92 12.41 2.92 12C2.92 11.59 3.26 11.25 3.67 11.25Z"
                      fill="#2F415E"/>
            </svg>
            Back to order list</a>
        @php $order_id = request()->route('id') @endphp
        {{-- header --}}
        <div class="order-details-header d-flex mgb-20">
            <div class="left d-flex align-items-center">
                <h4 class="fs-24 fw-bold text-light-black mb-0 mgr-20">Order details</h4>
                @if($diff_in_days > 0)
                    <span class="due">Due in {{ $diff_in_days }} days</span>
                @else
                    <span class="due">Already Overdue</span>
                @endif
            </div>
            <div class="right d-flex align-items-center ms-auto">
                <div class="current-status-group d-flex align-items-center mgr-20">
                    <label for="role" class="d-block text-light-black me-3">Current status</label> 
                    <div class="position-relative">
                        <select name="role" id="role" class="login-input role-error fw-bold">
                            <option value="">Not done</option> 
                            <option value="3" class="text-capitalize">Done</option> 
                            <option value="2" class="text-capitalize">admin</option>
                        </select> 
                        <span class="icon-arrow-down bottom-arrow-icon text-gray"></span>
                    </div>
                </div>
                <a href="#" class="button button-primary h-40 d-inline-flex align-items-center mgr-20"><span class="mgr-20">Schedule</span> <span class="icon-calendar"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span></a>
                <a href="#" class="button button-primary h-40 d-inline-flex align-items-center"><span class="mgr-20">Share order</span> <span class="icon-share"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></span></a>
            </div>
        </div>
        <div class="order-details-box-main row">
            <div class="order-details__left col-md-6">
                {{-- Basic Information --}}
                <basic-info :order-id="'{{ $order_id }}'"></basic-info>
                {{-- Borrower --}}
                <borrower :order-id="'{{ $order_id }}'"></borrower>
                {{-- Contact --}}
                <contact :order-id="'{{ $order_id }}'"></contact>
                {{-- Inspection --}}
                <inspection :order-id="'{{ $order_id }}'"></inspection>
                {{-- Issues --}}
                <issues></issues>
            </div>
            <div class="order-details__right col-md-6">
                {{-- Appraisal Details --}}
                <appraisal-details :order-id="'{{ $order_id }}'"></appraisal-details>
                {{-- Client --}}
                <client-info :order-id="'{{ $order_id }}'"></client-info>
                {{-- Call log --}}
                <call-log></call-log>
                {{-- Map --}}
                <map-view></map-view>
            </div>
        </div>
        <div class="row">
            <workflow></workflow>
            <history></history>
        </div>
        <div class="mgt-32">
            <files></files>
        </div>

        <div class="note-grid">
             {{-- Invoice --}}
             <invoice></invoice>
             {{-- Note --}}
             <notes></notes>
            {{-- Activity log --}}
            <activity-log :order-id="'{{ $order_id }}'"></activity-log>
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
