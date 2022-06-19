@extends('layouts.app')
@section('content')
   <div class="calls bg-platinum dashboard-space">
        <div class="bg-white pd-32">
            <div class="calls__menu d-flex">
                <div class="left chart-box-header-btn d-flex flex-wrap me-3">
                    <button class="calls-btn h-40 d-flex align-items-center mb-2 active">Appraiser <span class="ms-2"> (88)</span></button>
                    <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2"> (88)</span></button>
                    <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2"> (88)</span></button>
                    <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2"> (88)</span></button>
                    <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2"> (88)</span></button>
                </div>
                <div class="right d-flex ms-auto">
                    <a href="#" class="primary-bg h-40 d-flex align-items-center mb-2 px-2 br-4 text-white me-3">Map selected orders <span class="ms-2">(32)</span></a>
                    <div class=" d-flex calls-search">
                        <input type="text" class="mb-3 px-3 bdr-1 br-4 gray-border calls-search-input h-40" placeholder="Search...">
                        <button class="bg-gray inline-flex-center mb-2 calls-search-btn">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.33333 13.6667C10.8311 13.6667 13.6667 10.8311 13.6667 7.33333C13.6667 3.83553 10.8311 1 7.33333 1C3.83553 1 1 3.83553 1 7.33333C1 10.8311 3.83553 13.6667 7.33333 13.6667Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17 17L13 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            {{-- call management list --}}
            <div class="call-list">
                {{-- header --}}
                <div class="call-list-header">
                    <span class="call-list-item ">SL</span>
                    <span class="call-list-item ">Order no</span>
                    <span class="call-list-item ">Client name</span>
                    <span class="call-list-item ">Property address</span>
                    <span class="call-list-item ">Inspector</span>
                    <span class="call-list-item ">Appraiser</span>
                    <span class="call-list-item ">Last call</span>
                    <span class="call-list-item ">Insp. date & time</span>
                    <span class="call-list-item ">Status</span>
                    <span class="call-list-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.25" d="M17.028 0H6.972C2.604 0 0 2.604 0 6.972V17.028C0 21.396 2.604 24 6.972 24H17.028C21.396 24 24 21.396 24 17.028V6.972C24 2.604 21.396 0 17.028 0Z" fill="#2F415E"/>
                            <path d="M19.5727 8.244C19.5727 8.736 19.1767 9.144 18.6727 9.144H12.3727C11.8807 9.144 11.4727 8.736 11.4727 8.244C11.4727 7.752 11.8807 7.344 12.3727 7.344H18.6727C19.1767 7.344 19.5727 7.752 19.5727 8.244Z" fill="#2F415E"/>
                            <path d="M9.56388 7.08L6.86387 9.78C6.68387 9.96 6.45588 10.044 6.22788 10.044C5.99988 10.044 5.75988 9.96 5.59188 9.78L4.69188 8.88C4.33187 8.532 4.33187 7.956 4.69188 7.608C5.03988 7.26 5.60388 7.26 5.96388 7.608L6.22788 7.872L8.29188 5.808C8.63987 5.46 9.20388 5.46 9.56388 5.808C9.91188 6.156 9.91188 6.732 9.56388 7.08Z" fill="#2F415E"/>
                            <path d="M19.5727 16.644C19.5727 17.136 19.1767 17.544 18.6727 17.544H12.3727C11.8807 17.544 11.4727 17.136 11.4727 16.644C11.4727 16.152 11.8807 15.744 12.3727 15.744H18.6727C19.1767 15.744 19.5727 16.152 19.5727 16.644Z" fill="#2F415E"/>
                            <path d="M9.56388 15.48L6.86387 18.18C6.68387 18.36 6.45588 18.444 6.22788 18.444C5.99988 18.444 5.75988 18.36 5.59188 18.18L4.69188 17.28C4.33187 16.932 4.33187 16.356 4.69188 16.008C5.03988 15.66 5.60388 15.66 5.96388 16.008L6.22788 16.272L8.29188 14.208C8.63987 13.86 9.20388 13.86 9.56388 14.208C9.91188 14.556 9.91188 15.132 9.56388 15.48Z" fill="#2F415E"/>
                        </svg>                            
                    </span>
                </div>
                {{--  --}}
                <div class="call-list-body">
                    <span class="call-list-item">
                        <input id="list-item-1" type="checkbox">
                        <label for="list-item-1"></label>
                    </span>
                    <span class="call-list-item">56567456</span>
                    <span class="call-list-item"><p class="mb-0 fw-bold">Petter lake</p></span>
                    <span class="call-list-item"><p>1453 Dorchester Ave fevlpn ksdfkdsj amjad.</p></span>
                    <span class="call-list-item">Kabir khan</span>
                    <span class="call-list-item">Kabir khan</span>
                    <span class="call-list-item">12.03.2022</span>
                    <span class="call-list-item">12.03.2022, 3:00PM</span>
                    <span class="call-list-item"><p>Scheduled</p></span>
                    <span class="call-list-item">
                        <a href="#" class="icon-list"><span class="icon-eye text-blue-eye fs-20"><span class="path1"></span><span class="path2"></span></span></a>
                        <a href="#" class="icon-list"><span class="icon-note text-purple fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
                        <a href="#" class="icon-list"><span class="icon-messages2 primary-text fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span></a>
                        <a href="#" class="icon-list"><span class="icon-calendar text-brown fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span></a>
                        <a href="#" class="icon-list"> <span class="icon-messages text-yellow-msg  fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></a>
                        <a href="#" class="icon-list"><span class="icon-call text-light-red fs-20"><span class="path1"></span><span class="path2"></span></span></a>
                        <button class="button button-transparent p-0"><span class="icon-arrow-bottom"></span></button>
                    </span>
                </div>
            </div>
        </div>
   </div>
 @endsection
