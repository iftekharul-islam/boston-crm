@extends('layouts.app')

@section('content')
    <div class="role-permission bg-platinum dashboard-space">
        <div class="d-flex justify-content-between">
            <p class="mb-0 text-light-black fs-20 fw-bold">{{ __('messages.role_view.role_management') }}</p>
            <a href="{{ route('roles.create') }}" class="button button-primary"
               role="button">{{ __('messages.role_view.role_create') }}</a>
        </div>
        {{-- role preview --}}
        <div class="role-preview">
            @foreach($roles ?? [] as $key => $role)
                @php
                    $permission_list = $role->permissions()->pluck( 'name' )->toArray();
                @endphp
                <div class="role-box">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="mb-0 text-light-black fs-20 fw-bold">{{ $role->name }}</p>
                        <div class="d-flex align-items-center">
                            @if($role->name !== 'admin')
                                <span class="delete me-3"
                                      data-id="{{ $role->id }}"
                                      data-action="{{ route('roles.destroy',$role->id) }}"
                                      onclick="deleteConfirmation({{$role->id}})">
                        <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                    </span>
                                <a href="#" class="edit-btn h-32 inline-flex-center">
                                    {{ __('messages.edit') }}
                                    <span class="icon-edit ms-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </span>
                                </a>
                            @endif
                        </div>
                    </div>
                    {{--                    <p class="text-light-black mgb-32">First, you add your personal and professional information using a--}}
                    {{--                        simple editor.</p>--}}
                    @foreach($permissions as $permission)
                        <div class="d-flex permission-check flex-wrap">
                            <p class="mb-0 fw-bold text-light-black permission"><span
                                        class="text-capitalize">{{ $permission }}</span>
                                {{ __('messages.role_view.permission') }}</p>
                            @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                                <div class="checkbox-group">
                                    <input type="checkbox" class="checkbox-input"
                                           @if(in_array($permission_type. '.' . $permission, $permission_list)) checked
                                           @endif disabled>
                                    <label for="" class="checkbox-label text-capitalize">{{ $permission_type }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        {{-- role create--}}
        <div class="role-add mgt-32 new-role d-none">
            <div class="role-box">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="max-w-424 mgb-32">
                        <div class="mgb-20">
                            <input type="text" class="dashboard-input w-100 " placeholder="Name here...">
                        </div>
                        <textarea name="" class="dashboard-textarea w-100" id="" cols="30" rows="2"
                                  placeholder="Description here..."></textarea>
                    </div>
                    <span class="delete">
                        <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                    </span>
                </div>
                @foreach($permissions as $permission)
                    <div class="d-flex permission-check flex-wrap">
                        <p class="mb-0 fw-bold text-light-black permission"><span
                                    class="text-capitalize">{{ $permission }}</span>
                            {{ __('messages.role_view.permission') }}</p>
                        @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                            <div class="checkbox-group">
                                <input type="checkbox" class="checkbox-input">
                                <label for="" class="checkbox-label text-capitalize">{{ $permission_type }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="text-end">
                    <button class="button button-primary h-32 py-1 px-4">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        function createNewRole() {

        }
        function deleteConfirmation(id) {
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
                        url: "{{url('/roles')}}/" + id,
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
@endpush
