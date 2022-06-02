@extends('layouts.app')
@section('content')
    <div class="clients client-view bg-platinum dashboard-space">
        <a href="/clients" class="text-light-black d-inline-flex align-items-center mgb-24"> <svg class="me-2" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.57086 0.180005C7.76086 0.180005 7.95086 0.250005 8.10086 0.400004C8.39086 0.690004 8.39086 1.17 8.10086 1.46L2.56086 7L8.10086 12.54C8.39086 12.83 8.39086 13.31 8.10086 13.6C7.81086 13.89 7.33086 13.89 7.04086 13.6L0.970859 7.53C0.680859 7.24 0.680859 6.76 0.970859 6.47L7.04086 0.400004C7.19086 0.250005 7.38086 0.180005 7.57086 0.180005Z" fill="#2F415E"/>
            <path d="M1.67 6.25L18.5 6.25C18.91 6.25 19.25 6.59 19.25 7C19.25 7.41 18.91 7.75 18.5 7.75L1.67 7.75C1.26 7.75 0.92 7.41 0.92 7C0.92 6.59 1.26 6.25 1.67 6.25Z" fill="#2F415E"/>
            </svg>  Back to client list</a>
        <div class="clients-box client-view-box bg-white">
            <div class="d-flex justify-content-between">
                {{-- tabs button --}}
                <ul class="nav nav-pills mb-3 clients-tabs" id="pills-tab" role="tablist">
                    <li class="nav-item mb-3" role="presentation">
                        <button class="nav-link active" id="pills-personal-info-tab" data-bs-toggle="pill" data-bs-target="#pills-personal-info" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Details info</button>
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
                @if(in_array('update.client', $user_permissions))
                <div class="edit">
                    <a href="{{ route('clients.edit',$client->id) }}" class="edit-btn h-32 inline-flex-center mb-3">
                        Edit
                        <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span>
                    </a>
                </div>
                @endif
            </div>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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
                                <div class="right-side">
                                @if($client->phone != null)
                                    @foreach(json_decode($client->phone) as $phone)
                                    <p class="mb-0">{{ $phone }}</p>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Email address</p>
                                <span>:</span>
                                <div class="right-side">
                                @if($client->email != null)
                                    @foreach(json_decode($client->email) as $email)
                                        <p class="right-side">{{ $email }}</p>
                                    @endforeach
                                @endif
                                </div>
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
                                <p class="mb-0 left-side">Created By</p>
                                <span>:</span>
                                <p class="right-side">{{ $client->user->name  }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Created At</p>
                                <span>:</span>
                                <p class="right-side">{{ date('d M Y H:i A',strtotime($client->created_at))  }}</p>
                            </div>
                            <div class="personal-info__group">
                                <p class="mb-0 left-side">Client instruction</p>
                                <span>:</span>
                                <p class="right-side"><a @if(isset($client->getMedia('clients')[0])) target="_blank" @else style="color: dimgray !important;cursor: default !important;" @endif href="{{ isset($client->getMedia('clients')[0]) ? $client->getMedia('clients')[0]->getFullUrl() : '#' }}"> @if(isset($client->getMedia('clients')[0])) Instruction File @else No File @endif</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    setInterval(function () {
        $("div.alert-success").hide();
        $("div.alert-danger").hide();
    }, 3000);
</script>
