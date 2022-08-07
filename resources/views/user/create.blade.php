@extends('layouts.app')
@section('content')
<div class="user-registration bg-login-box">
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
    <div class=" max-w-1576 mx-auto">
        <form action="{{ url('create-direct-user') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="user-registration__box bg-white br-8 pdt-32">
                <div class="pdl-32">
                    <p class="fs-20 text-600 text-light-black mb-3">Add new user </p>
                </div>
                <div class="box-row">
                    <div class="bg-platinum h-100 pd-32 br-8">
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Full name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="dashboard-input w-100"
                                name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Role <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="">Please select a role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(old('role')==$role->id) selected @endif>{{
                                    $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="dashboard-input w-100">
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Phone <span
                                    class="text-danger">*</span></label>
                            <input type="text" maxlength="14" onkeyup="return formatPhoneNo(event)"
                                class="dashboard-input w-100" name="phone" id="phone"
                                value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="bg-platinum h-100 pd-32 br-8">
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" minlength="6" class="dashboard-input w-100 @error('password') is-invalid @enderror"
                                name="password">
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" minlength="6" class="dashboard-input w-100" name="password_confirmation">
                        </div>
                        <div class="group ">
                            <label for="img_preview" class="d-block mb-3 dashboard-label fw-bold">User photo (optional)</label>
                            <div id='img_preview' class="img__preview">
                                <img id="blah" src="{{ asset('img/user.png') }}" alt="your image" class="img-fluid"
                                    title='' />
                                <div class="upload-img">
                                    <input type="file" id="inputGroupFile01" class="imgInp custom-file-input"
                                        name="image" accept="image/png, image/jpeg"
                                        aria-describedby="inputGroupFileAddon01">
                                    <span class="icon-camera"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></span>
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
                            <label for="" class="d-block mb-2 dashboard-label">Address</label>
                            <textarea name="address" id="" cols="30" rows="2"
                                class="dashboard-textarea w-100 @error('address') is-invalid @enderror">
                                    {{ old('address') }}
                                </textarea>
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">City</label>
                            <input type="text" class="dashboard-input w-100 @error('city') is-invalid @enderror"
                                name="city" value="{{ old('city') }}">
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">State</label>
                            <input type="text" class="dashboard-input w-100 @error('state') is-invalid @enderror"
                                name="state" value="{{ old('state') }}">
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Zip code</label>
                            <input type="text" class="dashboard-input w-100 @error('zip_code') is-invalid @enderror"
                                name="zip_code" value="{{ old('zip_code') }}">
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

    function filterPhoneNumber(val) {
        let check1 = val.replace("(", "");
        let check2 = check1.replace(")", "");
        let check3 = check2.replace("-", "");
        let check4 = check3.replace(" ", "");
        let check5 = check4.replace("+", "");
        return check5;
    }

    function formatPhoneNo(e) {
        let phoneNo = e.target.value;
        phoneNo = filterPhoneNumber(phoneNo);
        e.target.value = phoneNo.replace(/(\d{3})\-?(\d{3})\-?(\d{4}).*/, '$1-$2-$3')
    }
</script>
@endsection
