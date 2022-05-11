@extends('layouts.app')
@section('content')
    <div class="clients client-view bg-platinum dashboard-space">
        <div class="clients-box client-view-box bg-white">
            <div class="d-flex justify-content-between">
                {{-- tabs button --}}
                <ul class="nav nav-pills mb-3 clients-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item mb-3" role="presentation">
                        <button class="nav-link active" id="pills-personal-info-tab" data-bs-toggle="pill" data-bs-target="#pills-personal-info" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Personal info</button>
                    </li>
                    <li class="nav-item mb-3" role="presentation">
                        <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill" data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order" aria-selected="false">Orders</button>
                    </li>
                    <li class="nav-item mb-3" role="presentation">
                        <button class="nav-link" id="pills-invoice-tab" data-bs-toggle="pill" data-bs-target="#pills-invoice" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Invoice</button>
                    </li>
                    <li class="nav-item mb-3" role="presentation">
                        <button class="nav-link" id="pills-statistics-tab" data-bs-toggle="pill" data-bs-target="#pills-statistics" type="button" role="tab" aria-controls="pills-statistics" aria-selected="false">Statistics</button>
                    </li>
                    <li class="nav-item mb-3" role="presentation">
                        <button class="nav-link" id="pills-message-tab" data-bs-toggle="pill" data-bs-target="#pills-message" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Notes & message</button>
                    </li>
                </ul>
                <div class="edit">
                    <a href="{{ route('clients.edit',$client->id) }}" class="edit-btn h-32 inline-flex-center mb-3">
                        Edit
                        <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span>
                    </a>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                {{-- personal info --}}
                <div class="tab-pane fade show active" id="pills-personal-info" role="tabpanel" aria-labelledby="pills-personal-info-tab">
                    <div class="row personal-info">
                        <div class="col-lg-6 mb-3 left">
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Client name</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->name }}</p>
                            </div>
                            {{--                            <div class="personal-info__group">--}}
                            {{--                                <p class="mb-0 left-side">Client URL</p>--}}
                            {{--                                <span>:</span>--}}
                            {{--                                <p title="https://www.mytitlesourceconnection.com/Vendor/" class="right-side">https://www.mytitlesourceconnection.com/Vendor/...</p>--}}
                            {{--                            </div>--}}
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Address</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->address }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Client type</p>
                                <span>:</span>
                                <p class="right-side">{{ strtoupper($client->client_type) }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">City</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->city }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">State</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->state }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Zip code</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->zip }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Phone no</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->phone }}</p>
                            </div>
                            {{--                            <div class="personal-info__group">--}}
                            {{--                                <p class="mb-0 left-side">Fax no</p>--}}
                            {{--                                <span>:</span>--}}
                            {{--                                <p class="right-side">Amrock</p>--}}
                            {{--                            </div>--}}
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Email address</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->email }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3 right">
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Technology fee for full
                                    appraisal like 1004UAD</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->fee_for_1004uad }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Technology fee for partial
                                    appraisal like 1004D</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->fee_for_1004d }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Deducts technology fee?</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->deducts_technology_fee == 1 ? 'Yes' : 'No' }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Trainee sign</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->can_sign == 1 ? 'Yes' : 'N/A'  }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Trainee inspect</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->can_inspect == 1 ? 'Yes' : 'N/A'  }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Client instruction</p>
                                <span>:</span>
                                <p class="right-side"><a @if(isset($client->getMedia('clients')[0])) target="_blank" @else style="color: dimgray !important;cursor: default !important;" @endif href="{{ isset($client->getMedia('clients')[0]) ? $client->getMedia('clients')[0]->getFullUrl() : '#' }}"> @if(isset($client->getMedia('clients')[0])) Instruction File @else No File @endif</a></p>
                            </div>
{{--                            <div class="personal-info__group">--}}
{{--                                <p class="mb-0 left-side">Technology fee</p>--}}
{{--                                <span>:</span>--}}
{{--                                <p class="right-side">$123</p>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
                {{-- order --}}
{{--                <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab">--}}
{{--                    Order--}}
{{--                </div>--}}
{{--                --}}{{-- Invoice --}}
{{--                <div class="tab-pane fade" id="pills-invoice" role="tabpanel" aria-labelledby="pills-invoice-tab">--}}
{{--                    Invoice--}}
{{--                </div>--}}
{{--                --}}{{-- statistics --}}
{{--                <div class="tab-pane fade" id="pills-statistics" role="tabpanel" aria-labelledby="pills-statistics-tab">--}}
{{--                    Statistics--}}
{{--                </div>--}}
{{--                --}}{{-- Note messasge --}}
{{--                <div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="pills-message-tab">--}}
{{--                    Note and Message--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
