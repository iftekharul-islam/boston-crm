@extends('layouts.app')

@section('content')
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
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label"> {{ __('messages.profile_view.company_name') }}
                                                <span class="text-danger require"></span></label>
                                            <input type="text" class="dashboard-input w-100" name="company_name"
                                                   value="{{ $company->name ?? '' }}"
                                                   @if($company->owner_id != $user->id) readonly @endif>
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.name') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="user_name"
                                                   value="{{ $user->name ?? '' }}">
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.address') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="address"
                                                   value="{{ $profile->address ?? '' }}">
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.city') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="city"
                                                   value="{{ $profile->city ?? '' }}">
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.state') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="state"
                                                   value="{{ $profile->state ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="right max-w-424 w-100">
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.zip') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="zip_code"
                                                   value="{{ $profile->zip_code ?? '' }}">
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.phone') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="phone"
                                                   value="{{ $profile->phone ?? '' }}">
                                        </div>
                                        <div class="group">
                                            <label for=""
                                                   class="d-block mb-2 dashboard-label">{{ __('messages.profile_view.email') }}</label>
                                            <input type="text" class="dashboard-input w-100" name="email"
                                                   value="{{ $user->email }}" readonly>
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
