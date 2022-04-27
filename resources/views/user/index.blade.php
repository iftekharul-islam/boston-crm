@extends('layouts.app')

@section('content')
    <div class="clients bg-platinum dashboard-space">
        <div class="clients-box user-box clients-box-main bg-white">
            <div class="clients-top d-flex flex-wrap justify-content-between">
                <p class="mb-0 text-light-black fs-20 text-600">User management</p>
                <button data-bs-toggle="modal" data-bs-target="#userInviteModal" class="button button-primary"
                        role="button">{{ __('messages.user_view.user_create') }}</button>
            </div>
            <div class="clients-table user-table mt-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('messages.user_view.user_name') }}</th>
                        <th scope="col">{{ __('messages.user_view.user_email') }}</th>
                        <th scope="col">{{ __('messages.user_view.role') }}</th>
                        <th scope="col">{{ __('messages.user_view.percentage') }}</th>
                        <th scope="col">{{ __('messages.user_view.phone') }}</th>
                        <th scope="col">{{ __('messages.user_view.join_date') }}</th>
                        <th scope="col">{{ __('messages.user_view.address') }}</th>
                        <th scope="col">{{ __('messages.status') }}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users ?? [] as $key => $user)
                        @php
                            $profile = $user->userProfile;
							$role_name = $user->getUserRole($user->id, $company->id);
                        @endphp
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="role-results-td">
                                <div class="role-results role-view-{{ $user->id }}">
                                    <span class="role-name"> {{ $role_name }}</span>
                                    @if($company->owner_id !== $user->id)
                                        <span class="icon-edit fs-20 cursor-pointer" onclick="roleUpdateOpen({{ $user->id }});"><span
                                                    class="path1"></span><span class="path2"></span></span>
                                    @endif
                                </div>
                                <div class="role-results role-update-{{ $user->id }} d-none">
                                    <div class="group role-results-group">
                                        <div class="position-relative select-box">
                                            <select name="role_id" id="userRole{{ $user->id }}"
                                                    class="login-input w-100">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                            class="text-capitalize"
                                                            @if($role_name === $role->name) selected @endif>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                        {{-- <div class="d-flex align-items-center"> --}}
                                            <span class="icon-close-circle fs-28 mx-2 cursor-pointer"
                                              onclick="roleUpdateClose({{ $user->id }});"><span
                                                    class="path1"></span><span class="path2"></span></span>

                                            <span class="cursor-pointer fs-20" onclick="roleUpdate({{ $user->id }});">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="22" height="22" rx="11" fill="#34A851"/>
                                                    <path d="M9.42745 14.3411C9.18842 14.3411 8.94939 14.253 8.76068 14.0643L6.87362 12.1772C6.50879 11.8124 6.50879 11.2086 6.87362 10.8437C7.23845 10.4789 7.84231 10.4789 8.20715 10.8437L9.42745 12.064L13.7929 7.69862C14.1577 7.33379 14.7615 7.33379 15.1264 7.69862C15.4912 8.06346 15.4912 8.66731 15.1264 9.03215L10.0942 14.0643C9.91808 14.253 9.66648 14.3411 9.42745 14.3411Z" fill="white"/>
                                                    </svg>                                                                                                    
                                            </span>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($company->owner_id !== $user->id)
                                    <span class="role-name">
                                        50%
                                    </span><span class="icon-edit fs-20"><span
                                                class="path1"></span><span class="path2"></span></span>
                                @endif
                            </td>
                            <td>{{ $profile->phone ?? '' }}</td>
                            <td>{{ $user->pivot->join_date }}</td>
                            <td>{{ \App\Helpers\Helper::subStrWords($profile->address ?? '', 20) }}</td>
                            <td>
                                @if($company->owner_id !== $user->id)
                                    <div class="switch">
                                        <input class="switch-input" type="checkbox" id="switch{{ $user->id }}"
                                               onclick="userStatusChange({{ $user->id }})"
                                               @if($user->pivot->status) checked @endif/>
                                        <label class="switch-label" for="switch{{ $user->id }}"></label>
                                        <span class="active-switch switch-status">{{ __('messages.active') }}</span>
                                        <span class="inactive-switch switch-status">{{ __('messages.inactive') }}</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)" class="me-3 text-light-black cursor-pointer"
                                       onclick="profileModalOpen({{ $user }}, {{ $user->userProfile }});">
                                        <span class="icon-eye fs-20"><span class="path1"></span><span
                                                    class="path2"></span></span></a>
                                    @if($company->owner_id !== $user->id)
                                        <a class="cursor-pointer text-light-black" data-id="{{ $user->id }}"
                                           data-action="{{ route('users.destroy',$user->id) }}"
                                           onclick="deleteConfirmation({{$user->id}})"> <span
                                                    class="icon-trash fs-20"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span></span></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="pagination-wrapper">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
        {{-- create user modal --}}
        @include('user._invite-user-modal')

        <!-- User profile Modal -->
        @include('user._user-profile-modal')
    </div>

@endsection

@section('js')
    <script>
        /**
         *
         * @param id
         */
        function roleUpdateOpen(id) {
            $('.role-view-' + id).addClass('d-none');
            $('.role-update-' + id).removeClass('d-none');
        }

        /**
         *
         * @param id
         */
        function roleUpdateClose(id) {
            $('.role-view-' + id).removeClass('d-none');
            $('.role-update-' + id).addClass('d-none');
        }

        function roleUpdate(id) {
            let role_id = $('#userRole' + id + ' option:selected').val();
            let url = '{{ route("users.update", ":id") }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: "PUT",
                data: {
                    "_token": "{{ csrf_token() }}",
                    role: role_id,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    let errors = response.responseJSON.errors;
                },
            });
        }

        function inviteUser() {
            $('#emailErrorMsg').text('');
            $('#roleErrorMsg').text('');
            let role_id = $('#role option:selected').val();
            let email = $('#email').val();
            if(email.length === 0 || role_id.length === 0) {
                $('#emailErrorMsg').text('Email is required');
                $('#roleErrorMsg').text('Role is required');
                return;
            }
            let url = '{{ route("users.store") }}';

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    role: role_id,
                    email: email
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    let errors = response.responseJSON.errors;
                    $('#emailErrorMsg').text(errors.email);
                    $('#roleErrorMsg').text(errors.role);
                },
            });
        }

        /**
         *
         * @param user
         * @param user_profile
         */
        function profileModalOpen(user, user_profile) {
            $("#userProfile").modal('show');
        }

        function profileModalClose() {
            $("#userProfile").modal('hide');
        }

        /**
         * User profile status change.
         *
         * @param id
         */
        function userStatusChange(id) {
            let url = '{{ route("users.status.change", ":id") }}';
            url = url.replace(':id', id);
            swal({
                title: "Are you sure want to change status?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Change status",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                        location.reload();
                                    }
                                );
                            } else {
                                swal("Error!", results.message, "error").then(function () {
                                        location.reload();
                                    }
                                );
                            }
                        }
                    });

                } else {
                    e.dismiss;
                    location.reload();
                }

            }, function (dismiss) {
                return false;
            })
        }

        /**
         * User delete id.
         *
         * @param id
         */
        function deleteConfirmation(id) {
            let url = '{{ route("users.destroy", ":id") }}';
            url = url.replace(':id', id);
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                        location.reload();
                                    }
                                );
                            } else {
                                swal("Error!", results.message, "error").then(function () {
                                        location.reload();
                                    }
                                );
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }
    </script>
@endsection
