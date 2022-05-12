@extends('layouts.app')
@section('content')
    <div class="clients bg-platinum dashboard-space">
        <div class="clients-box add-client bg-white">
            <form action="{{ route('clients.update',$client->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="add-client-form">
                    <p class="text-light-black fs-20 mgb-16">Update client</p>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col-lg-8 left mb-3">
                            <div class="d-flex box justify-content-between left__wrap">
                                <div class="left-side max-w-424 w-100 me-3">
                                    <div class="group">
                                        <label for="name" class="d-block mb-2 dashboard-label">Client name <span
                                                    class="text-danger require"></span></label>
                                        <input type="text" id="name" name="name" value="{{ $client->name }}" class="dashboard-input w-100" required>
                                    </div>
                                    <div class="group">
                                        <label for="client-type" class="d-block mb-2 dashboard-label">Client type <span
                                                    class="text-danger require"></span></label>
                                        <div class="position-relative">
                                            <select name="client_type" id="client-type" class="dashboard-input w-100">
                                                <option value="">Select a type</option>
                                                <option value="amc" @if($client->client_type == 'amc') selected @endif>Amc</option>
                                                <option value="lender" @if($client->client_type == 'lender') selected @endif>Lender</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    {{--                                    <div class="group">--}}
                                    {{--                                        <label for="" class="d-block mb-2 dashboard-label">Client URL <span--}}
                                    {{--                                                    class="text-danger require"></span></label>--}}
                                    {{--                                        <input type="text" class="dashboard-input w-100">--}}
                                    {{--                                    </div>--}}
                                    <div class="group">
                                        <label for="email" class="d-block mb-2 dashboard-label">Email address <span
                                                    class="text-danger require"></span></label>
                                        <input type="email" id="email" name="email" value="{{ $client->email }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="phone" class="d-block mb-2 dashboard-label">Phone no <span
                                                    class="text-danger require"></span></label>
                                        <input type="text" name="phone" id="phone" value="{{ $client->phone }}" class="dashboard-input w-100"
                                               required>
                                    </div>
                                </div>
                                {{-- right side --}}
                                <div class="right-side max-w-424 w-100">
                                    <div class="group">
                                        <label for="address" class="d-block mb-2 dashboard-label address-label">Address
                                            <span
                                                    class="text-danger"></span></label>
                                        <textarea name="address" class="dashboard-textarea w-100" id="address" cols="30"
                                                  rows="2">{{ $client->address }}</textarea>
                                    </div>
                                    <div class="group">
                                        <label for="city" class="d-block mb-2 dashboard-label city-label">City <span
                                                    class="text-danger"></span></label>
                                        <input type="text" id="city" name="city" value="{{ $client->city }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="state" class="d-block mb-2 dashboard-label state-label">State <span
                                                    class="text-danger"></span></label>
                                        <input type="text" name="state" id="state" value="{{ $client->state }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="zip" class="d-block mb-2 dashboard-label zip-label">Zip code <span
                                                    class="text-danger"></span></label>
                                        <input type="text" id="zip" name="zip" value="{{ $client->zip }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="country" class="d-block mb-2 dashboard-label country-label">Country
                                            <span
                                                    class="text-danger"></span></label>
                                        <input type="text" name="country" id="country" value="{{ $client->country }}" class="dashboard-input w-100">
                                    </div>
                                    {{--                                    <div class="group">--}}
                                    {{--                                        <label for="" class="d-block mb-2 dashboard-label">Fax no <span--}}
                                    {{--                                                    class="text-danger require"></span></label>--}}
                                    {{--                                        <input type="text" class="dashboard-input w-100">--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 right mb-3">
                            <div class="box">
                                <div class="max-w-424 w-100">
                                    <div class="group">
                                        <label for="fee-for-1004UAD"
                                               class="d-block mb-2 dashboard-label fee-for-1004UAD-label">Technology fee
                                            for full
                                            appraisal like 1004UAD</label>
                                        <input type="text" name="fee_for_1004uad" value="{{ $client->fee_for_1004uad }}" id="fee-for-1004UAD"
                                               class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="fee-for-1004D"
                                               class="d-block mb-2 dashboard-label fee-for-1004D-label">Technology fee
                                            for full
                                            appraisal like 1004D</label>
                                        <input type="text" name="fee_for_1004d" value="{{ $client->fee_for_1004d }}" id="fee-for-1004D"
                                               class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="deducts-technology-fee"
                                               class="d-block mb-2 dashboard-label deducts-technology-fee-label">Deduction
                                            of tech fee during
                                            payment </label>
                                        <div class="position-relative">
                                            <select name="deducts_technology_fee" id="deducts-technology-fee"
                                                    class="dashboard-input w-100">
                                                <option value="">Choose an option</option>
                                                <option value="1" @if($client->deducts_technology_fee == 1) selected @endif>Yes</option>
                                                <option value="0" @if($client->deducts_technology_fee == 0) selected @endif>No</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="can-sign" class="d-block mb-2 dashboard-label can-sign-label">Trainee
                                            can sign </label>
                                        <div class="position-relative">
                                            <select name="can_sign" id="can-sign" class="dashboard-input w-100">
                                                <option value="">Select an option</option>
                                                <option value="1" @if($client->can_sign == 1) selected @endif>Yes</option>
                                                <option value="0" @if($client->can_sign == 0) selected @endif>N/A</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="can-inspect" class="d-block mb-2 dashboard-label can-inspect-label">Trainee
                                            can inspect </label>
                                        <div class="position-relative">
                                            <select name="can_inspect" id="can-inspect" class="dashboard-input w-100">
                                                <option value="">Select an option</option>
                                                <option value="1" @if($client->can_inspect == 1) selected @endif>Yes</option>
                                                <option value="0" @if($client->can_inspect == 0) selected @endif>N/A</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="instruction" class="d-block mb-2 dashboard-label can-inspect">Trainee
                                            can inspect </label>
                                        <div class="position-relative file-upload">
                                            <input type="file" name="instruction" id="instruction">
                                            <label for="">Upload <img src="/img/upload.png"
                                                                      alt="boston profile"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-client__bottom d-flex justify-content-end mgt-32 p-3">
                    <button class="button button-discard me-3 d-flex align-items-center" id="discard" type="button">Discard <span class="icon-close-circle ms-3"><span
                                    class="path1"></span><span class="path2"></span></span></button>
                    <button class="button button-primary" type="submit">Update client</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $("#client-create-form").validate({
                errorClass: "text-danger",
                messages : {
                    name: "Name is required",
                    client_type : "Client type is required",
                    email: "Email is required",
                    phone: "Phone No is required",
                    address: "Address is required",
                    zip: "Zip code is required",
                    state: "State is required",
                    country: "Country is required",
                    city: "City is required",
                    fee_for_1004uad: "Technology fee for full appraisal(1004UAD) is required",
                    fee_for_1004d: "Technology fee for full appraisal(1004D) is required",
                    deducts_technology_fee: "Deduction of tech fee is required",
                    can_sign: "Trainee can sign field is required",
                    can_inspect: "Trainee can inspect field is required"
                }
            });
            let clientType = $('#client-type').val();
            if(clientType === 'lender'){
                $(".address-label, .city-label, .state-label, .country-label, .zip-label").addClass('require');
                $("#address,#city,#state,#country,#zip").prop('required', true);
            }else{
                $(".deducts-technology-fee-label, .fee-for-1004UAD-label, .fee-for-1004D-label, .can-sign-label, .can-inspect-label").addClass('require');
                $("#deducts-technology-fee, #fee-for-1004UAD, #fee-for-1004D-label ,#can-sign, #can-inspect").prop('required', true);
            }
        });
        $('#client-type').on('change', function (e) {
            e.preventDefault();
            let clientType = $(this).val();
            if (clientType === 'lender') {
                $(".address-label, .city-label, .state-label, .country-label, .zip-label").addClass('require');
                $("#address,#city,#state,#country,#zip").prop('required', true);

                $(".deducts-technology-fee-label, .fee-for-1004UAD-label, .fee-for-1004D-label, .can-sign-label, .can-inspect-label").removeClass('require');
                $("#deducts-technology-fee, #fee-for-1004UAD, #fee-for-1004D-label ,#can-sign, #can-inspect").prop('required', false);
            } else {
                $(".deducts-technology-fee-label, .fee-for-1004UAD-label, .fee-for-1004D-label, .can-sign-label, .can-inspect-label").addClass('require');
                $("#deducts-technology-fee, #fee-for-1004UAD, #fee-for-1004D-label ,#can-sign, #can-inspect").prop('required', true);

                $(".address-label, .city-label, .state-label, .country-label, .zip-label").removeClass('require');
                $("#address,#city,#state,#country,#zip").prop('required', false);
            }
        });
        $("#discard").on("click",function (e){
            e.preventDefault();
            swal({
                title: "Are you sure you want to discard ?",
                text: "Changes will be lost!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(res => {
                if(res.value){
                    window.location.href = "{{ url('/clients') }}";
                }
            })
        });
    </script>
@endpush
