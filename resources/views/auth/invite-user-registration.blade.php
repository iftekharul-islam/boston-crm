@extends('layouts.app')

@section('content')
    <div class="user-registration bg-login-box">
        <div class=" max-w-1576 mx-auto">
            <h4 class="light-black fs-34 mgb-20 fw-bold">{{ $company->name }} has invited you to join team</h4>
            <form action="{{ route('update.invite.user.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="user-registration__box bg-white br-8">
                    <div class="box-row">
                        <div class="bg-platinum h-100 pd-32 br-8">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Your name</label>
                                <input type="text" class="dashboard-input w-100" name="name"
                                       value="{{ $user->name ?? '' }}">
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Address</label>
                                <textarea name="" id="" cols="30" rows="2"
                                          class="dashboard-textarea w-100">{{ $user->profile->address ?? '' }}</textarea>
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">City</label>
                                <input type="text" class="dashboard-input w-100">
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">State</label>
                                <input type="text" class="dashboard-input w-100">
                            </div>
                        </div>
                        <div class="bg-platinum h-100 pd-32 br-8">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Zip code</label>
                                <input type="text" class="dashboard-input w-100">
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Phone</label>
                                <input type="text" class="dashboard-input w-100">
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Email</label>
                                <input type="email" class="dashboard-input w-100">
                            </div>
                            <div class="group ">
                                <label for="" class="d-block mb-3 dashboard-label fw-bold">User photo</label>
                                <div id='img_preview' class="img__preview">
                                    <img id="blah" align='middle' src="{{ asset('img/user.png') }}" alt="your image"
                                         class="img-fluid" title=''/>
                                    <div class="upload-img">
                                        <input type="file" id="inputGroupFile01" class="imgInp custom-file-input"
                                               aria-describedby="inputGroupFileAddon01">
                                        <span class="icon-camera"><span class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span></span>
                                    </div>
                                </div>
                                <div class="custom-file">
                                    <label class="custom-file-label text-light-black mt-2 d-block"
                                           for="inputGroupFile01"></label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-platinum h-100 pd-32 br-8">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Username</label>
                                <input type="text" class="dashboard-input w-100">
                            </div>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Password</label>
                                <input type="password" class="dashboard-input w-100">
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
        $("#inputGroupFile01").change(function (event) {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var filename = $("#inputGroupFile01").val();
                filename = filename.substring(filename.lastIndexOf('\\') + 1);
                reader.onload = function (e) {
                    debugger;
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
