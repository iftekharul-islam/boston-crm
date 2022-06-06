@extends('layouts.app')
@section('content')
    <div class="clients bg-platinum dashboard-space">
        <div class="clients-box add-client bg-white">
            <form id="client-create-form" action="{{ route('clients.store') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="add-client-form">
                    <p class="text-light-black fs-20 mgb-16 fw-bold">Add new client</p>
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
                                        <label for="client-type" class="d-block mb-2 dashboard-label">Client type <span
                                                    class="text-danger require"></span></label>
                                        <div class="position-relative">
                                            <select name="client_type" id="client-type" class="dashboard-input w-100"
                                                    required>
                                                <option value="">Select a type</option>
                                                <option value="amc" {{ (old("client_type") == 'amc' ? "selected":"") }}>Amc</option>
                                                <option value="lender" {{ (old("client_type") == 'lender' ? "selected":"") }}>Lender</option>
                                                <option value="both" {{ (old("client_type") == 'both' ? "selected":"") }}>Both</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="name" class="d-block mb-2 dashboard-label">Client name <span
                                                    class="text-danger require"></span></label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="dashboard-input w-100" required>
                                    </div>
                                    <div class="group">
                                        <label for="email" class="d-block mb-2 dashboard-label">Email address <span
                                                    class="text-danger require"></span></label>
                                        <input type="email" id="email" name="email[]" class="dashboard-input w-100 mb-3" required>
                                        <div id="email-append" class="contact-append"></div>
                                        <div class="text-end">
                                            <button id="add-email" class="button button-transparent p-0 text-gray">+ Add More</button>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="phone" class="d-block mb-2 dashboard-label">Phone no <span class="text-danger require"></span></label>
                                        <input type="text" maxlength="12" onkeyup="return formatPhoneNo(event)" name="phone[]" id="phone"  class="dashboard-input w-100 mb-3" required>
                                        <div id="phone-append" class="contact-append"></div>
                                        <div class="text-end">
                                            <button id="add-phone" class="button button-transparent p-0 text-gray">+ Add More</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- right side --}}
                                <div class="right-side max-w-424 w-100">
                                    <div class="group">
                                        <label for="address" class="d-block mb-2 dashboard-label address-label">Address</label>
                                        <input type="text" id="address" name="address" value="{{ old('address') }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="city" class="d-block mb-2 dashboard-label city-label">City </label>
                                        <input type="text" id="city" name="city" value="{{ old('city') }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="state" class="d-block mb-2 dashboard-label state-label">State <span
                                                    class="text-danger"></span></label>
                                        <input type="text" name="state" id="state" value="{{ old('state') }}" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="zip" class="d-block mb-2 dashboard-label zip-label">Zip code <span
                                                    class="text-danger"></span></label>
                                        <input type="text" id="zip" name="zip" value="{{ old('zip') }}" class="dashboard-input w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 right mb-3">
                            <div class="box">
                                <div class="max-w-424 w-100">
                                    <div class="group">
                                        <label for="fee-for-1004UAD"
                                               class="d-block mb-2 dashboard-label fee-for-1004uad-label">Technology fee
                                            for
                                            appraisal like 1004UAD</label>
                                        <input type="number" onpaste="return false" min="0" onkeypress="return numbersOnly(event)" name="fee_for_1004uad" value="{{ old('fee_for_1004uad') }}" id="fee-for-1004uad"
                                               class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="fee-for-1004d" class="d-block mb-2 dashboard-label fee-for-1004d-label">Technology fee for appraisal like 1004D</label>
                                        <input type="number" onpaste="return false" min="0" onkeypress="return numbersOnly(event)" name="fee_for_1004d" value="{{ old('fee_for_1004d') }}" id="fee-for-1004d" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="deducts-technology-fee" class="d-block mb-2 dashboard-label deducts-technology-fee-label">Deduction of tech fee during payment </label>
                                        <div class="position-relative">
                                            <select name="deducts_technology_fee" value="{{ old('deducts_technology_fee') }}" id="deducts-technology-fee" class="dashboard-input w-100">
                                                <option value="">Choose an option</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="can-sign" class="d-block mb-2 dashboard-label can-sign-label">Trainee can sign </label>
                                        <div class="position-relative">
                                            <select name="can_sign" id="can-sign" class="dashboard-input w-100">
                                                <option value="">Choose an option</option>
                                                <option value="1">Yes</option>
                                                <option value="0">N/A</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="can-inspect" class="d-block mb-2 dashboard-label can-inspect-label">Trainee
                                            can inspect </label>
                                        <div class="position-relative">
                                            <select name="can_inspect" id="can-inspect" class="dashboard-input w-100">
                                                <option value="">Choose an option</option>
                                                <option value="1">Yes</option>
                                                <option value="0">N/A</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="instruction" class="d-block mb-2 dashboard-label">Requirement File</label>
                                        <div class="position-relative file-upload">
                                            <input type="file" accept="application/octet-stream,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                                                text/plain, application/pdf" name="instruction" id="instruction">
                                            <label for="">Upload <img src="{{ asset('/img/upload.png') }}"
                                                                      alt="boston profile"></label>
                                            <span class="text-success" id="file-name"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-client__bottom d-flex justify-content-end mgt-32 p-3">
                    <button class="button button-discard me-3 d-flex align-items-center text-light-black" id="discard" type="button">Discard <span
                                class="icon-close-circle ms-3"><span
                                    class="path1"></span><span class="path2"></span></span></button>
                    <button class="button button-primary" type="submit">Add client</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function numbersOnly(e){
            return e.charCode >= 48 && e.charCode <= 57;
        }

        function formatPhoneNo(e){
            let phoneNo = e.target.value;
            e.target.value = phoneNo.replace(/(\d{3})\-?(\d{3})\-?(\d{4}).*/,'$1-$2-$3')
        }

        let emailCount = 1;
        let phoneCount = 1;
        $('#add-email').on('click',function(e){
            e.preventDefault();
            $('#email-append').append('<div class="append-div" id="email-'+emailCount+'"><input type="email" name="email[]" class="email dashboard-input"><button type="button" id="'+emailCount+'" class=" button button-transparent p-0 contact-del-btn email-button"><span class="icon-trash"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></button></div>');
            emailCount++;
        });
        $(document).on('click', '.email-button', function(){
            let button_id = $(this).attr("id");
            $('#email-'+button_id+'').remove();
        });
        $('#add-phone').on('click',function(e){
            e.preventDefault();
            $('#phone-append').append('<div class="append-div" id="phone-'+ phoneCount+'"><input type="text" name="phone[]" maxlength="12" onkeyup="return formatPhoneNo(event)" class="phone dashboard-input"><button type="button" id="'+phoneCount+'" class="button button-transparent p-0 contact-del-btn phone-button"><span class="icon-trash"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></button></div>');
            phoneCount++;
        });
        $(document).on('click', '.phone-button', function(){
            let button_id = $(this).attr("id");
            $('#phone-'+button_id+'').remove();
        });
        $(function () {
            let clientType = '';
            $('#client-type').on('change', function (e) {
                e.preventDefault();
                clientType = $(this).val();
                if (clientType === 'lender') {
                    removeError();

                    $(".address-label, .city-label, .state-label, .zip-label").addClass('require');

                    $(".deducts-technology-fee-label, .fee-for-1004uad-label, .fee-for-1004d-label, .can-sign-label, .can-inspect-label").removeClass('require');
                }else if(clientType === 'both'){
                    removeError();

                    $(".address-label, .city-label, .state-label, .zip-label,.deducts-technology-fee-label, .fee-for-1004uad-label, .fee-for-1004d-label, .can-sign-label, .can-inspect-label").addClass('require');
                } else {
                    removeError();

                    $(".deducts-technology-fee-label, .fee-for-1004uad-label, .fee-for-1004d-label, .can-sign-label, .can-inspect-label").addClass('require');

                    $(".address-label, .city-label, .state-label, .zip-label").removeClass('require');

                }
            });
            $("#client-create-form").validate({
                rules: {
                    name: {
                        required: true,
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    client_type: {
                        required: true,
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    "phone[]": {
                        required: true,
                        phoneUS: true,
                    },
                    "email[]": {
                        required: true,
                        email: true,
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    address: {
                        required: function () {
                            return clientType === 'lender' || clientType === 'both'
                        },
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    zip: {
                        required: function () {
                            return clientType === 'lender' || clientType === 'both'
                        },
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    state: {
                        required: function () {
                            return clientType === 'lender' || clientType === 'both'
                        },
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    city: {
                        required: function () {
                            return clientType === 'lender' || clientType === 'both'
                        },
                        normalizer: function (value) {
                            return value.trim();
                        }
                    },
                    fee_for_1004uad: {
                        required: function () {
                            return clientType === 'amc' || clientType === 'both'
                        },
                        normalizer: function (value) {
                            return value.trim();
                        },
                        number: true
                    },
                    fee_for_1004d: {
                        required: function () {
                            return clientType === 'amc' || clientType === 'both'
                        },
                        normalizer: function (value) {
                            return value.trim();
                        },
                        number: true
                    },
                    deducts_technology_fee: {
                        required: function () {
                            return clientType === 'amc' || clientType === 'both'
                        }
                    },
                    can_sign: {
                        required: function () {
                            return clientType === 'amc' || clientType === 'both'
                        }
                    },
                    can_inspect: {
                        required: function () {
                            return clientType === 'amc' || clientType === 'both'
                        }
                    },
                },
                messages: {
                    name: {
                        required: "Client name is required"
                    },
                    client_type: {
                        required: "Client type is required"
                    },
                    "email[]": {
                        required: "Client email is required"
                    },
                    "phone[]": {
                        required: "Client phone number is required",
                        phoneUS: "Please enter a valid phone no. (i.e. 000-000-0000)"
                    },
                    address: {
                        required: "Address is required"
                    },
                    zip: {
                        required :"Zip code is required"
                    },
                    state: {
                        required : "State is required"
                    },
                    city: {
                        required: "City is required"
                    },
                    fee_for_1004uad: {
                        required : "Technology fee for full appraisal(1004UAD) is required",
                        number: "Please enter a valid number"
                    },
                    fee_for_1004d: {
                        required : "Technology fee for appraisal(1004D) is required",
                        number: "Please enter a valid number",
                    },
                    deducts_technology_fee: {
                        required : "Deduction of tech fee is required"
                    },
                    can_sign: {
                        required : "Trainee can sign field is required"
                    },
                    can_inspect: {
                        required:"Trainee can inspect field is required"
                    }
                },
                submitHandler: function (form) {
                    if(form.valid()){
                        form.submit();
                    }else{
                        $(this).data('validator').resetForm();
                        return false;
                    }

                }
            });
        });
        setInterval(function () {
            $("div.alert-success").hide();
            $("div.alert-danger").hide();
        }, 3000);
        $('#instruction').on('change',function() {
            let file = $('#instruction')[0].files[0].name;
            $('#file-name').text(file);
        });
        function removeError(){
            $("#client-create-form").data('validator').resetForm();
            $(document).find('.dashboard-input').removeClass('error');
        }
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
