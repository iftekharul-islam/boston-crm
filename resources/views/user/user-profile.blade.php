@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <h3 class="text-success text-center mt-2 success-msg">{{Session::get('success')}}</h3>
    @endif
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="order-add bg-platinum dashboard-space">
            <div class="order-add-box bg-white">
                <div class="order-add-box__form">
                    <div class="row mgb-32">
                        <div class="col-md-8 ">
                            <div class="form-box">
                                <h4 class="box-header mb-3">{{ __('messages.profile_view.my_profile') }}</h4>

                                <div class="d-flex justify-content-between w-100">
                                    <div class="left max-w-424 w-100 me-3">
                                        <div class="group">
                                            <label for="companyName"
                                                   class="d-block mb-2 dashboard-label"> {{ __('messages.profile_view.company_name') }}
                                                <span class="text-danger require"></span></label>
                                            <input type="text"
                                                   id="companyName"
                                                   class="dashboard-input w-100 @error('company_name') is-invalid @enderror"
                                                   name="company_name"
                                                   value="{{ $company->name ?? '' }}"
                                                   required
                                                   @if($company->owner_id != $user->id) readonly @endif
                                                   autocomplete="company_name"
                                                   autofocus>
                                            @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="userName"
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.name') }}</label>
                                            <input type="text"
                                                   id="userName"
                                                   class="dashboard-input w-100 @error('user_name') is-invalid @enderror"
                                                   name="user_name"
                                                   value="{{ $user->name ?? '' }}">
                                            @error('user_name')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="address"
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.address') }}</label>
                                            <input type="text"
                                                   id="address"
                                                   class="dashboard-input w-100 @error('address') is-invalid @enderror" name="address"
                                                   value="{{ $profile->address ?? '' }}">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="city"
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.city') }}</label>
                                            <input type="text"
                                                   id="city"
                                                   class="dashboard-input w-100 @error('city') is-invalid @enderror"
                                                   name="city"
                                                   value="{{ $profile->city ?? '' }}">
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="state"
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.state') }}</label>
                                            <input type="text"
                                                   id="state"
                                                   class="dashboard-input w-100 @error('city') is-invalid @enderror"
                                                   name="state"
                                                   value="{{ $profile->state ?? '' }}">
                                            @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="right max-w-424 w-100">
                                        <div class="group">
                                            <label for="zipCode"
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.zip') }}</label>
                                            <input type="text"
                                                   id="zipCode"
                                                   class="dashboard-input w-100 @error('zip_code') is-invalid @enderror"
                                                   name="zip_code"
                                                   value="{{ $profile->zip_code ?? '' }}">
                                            @error('zip_code')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for="phone"
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.phone') }}</label>
                                            <input type="text"
                                                   id="phone"
                                                   class="dashboard-input w-100 @error('phone') is-invalid @enderror" name="phone"
                                                   value="{{ $profile->phone ?? '' }}">
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.email') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="email"
                                                   value="{{ $user->email }}" readonly>
                                        </div>
                                        <div class="group ">
                                            <label for="" class="d-block mb-3 dashboard-label fw-bold">User photo</label>
                                            <div id='img_preview' class="img__preview">
                                                <img id="blah" align='middle' src="{{ $user->getMedia('profiles')[0] ?? false ? asset($user->getMedia('profiles')[0]->getUrl()) : asset('img/user.png') }}" alt="{{ $user->getMedia('profiles')[0]->name ?? '' }}"
                                                     class="img-fluid" title=''/>
                                                <div class="upload-img cursor-pointer">
                                                    <input type="file"
                                                           id="inputGroupFile01"
                                                           class="imgInp custom-file-input"
                                                           aria-describedby="inputGroupFileAddon01"
                                                           name="image"
                                                           accept="image/png, image/jpeg">
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
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="add-client__bottom d-flex justify-content-end  p-3">
                    <button type="submit" class="button button-primary"> {{ __('messages.save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        const MAX_FILE_SIZE = 3 * 1024 * 1024; // 1MB
        $(document).ready(function () {
            if ($(".success-msg")){
                setTimeout(function(){
                    $(".success-msg").fadeOut().addClass('d-none');
                }, 6000);
            }
        });

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
                let reader = new FileReader();
                let filename = $("#inputGroupFile01").val();
                filename = filename.substring(filename.lastIndexOf('\\') + 1);
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result).hide().fadeIn(500);
                    $('.custom-file-label').text(filename);
                }
                reader.readAsDataURL(input.files[0]);
            }
            $(".alert").removeClass("loading").hide();
        }
    </script>
@endsection
