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
            <h4 class="text-light-black fs-20 mb-3 text-600">{{ $company->name }} has invited you to join team</h4>
            <form action="{{ route('update.invite.user.profile', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="user-registration__box bg-white br-8 pdt-32">
                    <div class="pdl-32">
                        <p class="fs-20 text-600 text-light-black mb-3">Fillup this form </p>
                    </div>
                    <div class="box-row">
                        <div class="bg-platinum h-100 pd-32 br-8">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Your name <span class="text-danger">*</span></label>
                                <input type="text" class="dashboard-input w-100 @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Address</label>
                                <textarea name="address" id="" cols="30" rows="2"
                                          class="dashboard-textarea w-100 @error('address') is-invalid @enderror">
                                    {{ old('address') }}
                                </textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">City</label>
                                <input type="text" class="dashboard-input w-100 @error('city') is-invalid @enderror"
                                       name="city" value="{{ old('city') }}">
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">State</label>
                                <input type="text" class="dashboard-input w-100 @error('state') is-invalid @enderror"
                                       name="state" value="{{ old('state') }}">
                                @error('state')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="bg-platinum h-100 pd-32 br-8">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Zip code</label>
                                <input type="text" class="dashboard-input w-100 @error('zip_code') is-invalid @enderror"
                                       name="zip_code" value="{{ old('zip_code') }}">
                                @error('state')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Phone</label>
                                <input type="text" class="dashboard-input w-100 @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Email</label>
                                <input type="email" class="dashboard-input w-100" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="group ">
                                <label for="img_preview" class="d-block mb-3 dashboard-label fw-bold">User photo</label>
                                <div id='img_preview' class="img__preview">
                                    <img id="blah" align='middle' src="{{ asset('img/user.png') }}" alt="your image"
                                         class="img-fluid" title=''/>
                                    <div class="upload-img">
                                        <input type="file"
                                               id="inputGroupFile01"
                                               class="imgInp custom-file-input"
                                               name="image"
                                               accept="image/png, image/jpeg"
                                               aria-describedby="inputGroupFileAddon01">
                                        <span class="icon-camera"><span class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></span>
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <label class="custom-file-label text-light-black mt-2 d-block"
                                           for="inputGroupFile01"></label>
                                </div>
                                <p class="image-error text-danger"></p>
                            </div>
                        </div>
                        <div class="bg-platinum h-100 pd-32 br-8">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Username</label>
                                <input type="text" class="dashboard-input w-100" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="dashboard-input w-100 @error('password') is-invalid @enderror"
                                       name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="py-3 bg-platinum d-flex justify-content-end px-3 box-footer">
                        <button class="button button-primary px-5">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const MAX_FILE_SIZE = 3 * 1024 * 1024; // 3MB

        $("#inputGroupFile01").change(function (event) {
            $('.image-error').text("");
            let fileSize = this.files[0].size;
            if (fileSize > MAX_FILE_SIZE) {
                $('.image-error').text("File must not exceed 3 MB!");
                return;
            }
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var filename = $("#inputGroupFile01").val();
                filename = filename.substring(filename.lastIndexOf('\\') + 1);
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                    $('#blah').hide();
                    $('#blah').fadeIn(500);
                    $('.custom-file-label').text(filename);
                }
                reader.readAsDataURL(input.files[0]);
            }
            $(".alert").removeClass("loading").hide();
        }
    </script>
@endsection
