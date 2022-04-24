@extends('layouts.app')

@section('content')
    <div class="role-permission bg-platinum dashboard-space">
        <div class="d-flex justify-content-between">
            <p class="mb-0 text-light-black fs-20 fw-bold">{{ __('messages.role_view.role_management') }}</p>
            <button class="button button-primary" onclick="showNewRoleCreate();"
                    role="button">{{ __('messages.role_view.role_create') }}</button>
        </div>
        {{-- role create--}}
        <form id="createRole" class="mb-4">
            <div class="role-add mgt-32 new-role">
                <div class="role-box">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="max-w-424 mgb-32">
                            <div class="mgb-20">
                                <input type="text" id="createName" class="dashboard-input w-100"
                                       placeholder="Name here...">
                                <p class="text-danger createNameErrorMsg"></p>
                            </div>
                            <textarea id="createDescription" class="dashboard-textarea w-100" id="" cols="30" rows="2"
                                      placeholder="Description here..."></textarea>
                            <p class="text-danger createDescriptionErrorMsg"></p>
                        </div>
                        <span class="delete" onclick="showNewRoleCreate();">
                            <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span
                                        class="path3"></span><span class="path4"></span>
                            </span>
                        </span>
                    </div>
                    @foreach($permissions as $permission)
                        <div class="d-flex permission-check flex-wrap">
                            <p class="mb-0 fw-bold text-light-black permission"><span
                                        class="text-capitalize">{{ $permission }}</span>
                                {{ __('messages.role_view.permission') }}</p>
                            @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                                <div class="checkbox-group">
                                    <input type="checkbox" class="checkbox-input check-data"
                                           name="create_permission"
                                           data-name="{{ $permission_type . '.' . $permission }}"
                                           data-model-name="{{ $permission }}"
                                           value="{{ $permission_type . '.' . $permission }}">
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
        </form>
        {{-- role preview --}}
        <div class="role-preview">
            @foreach($roles ?? [] as $key => $role)
                @php
                    $permission_list = $role->permissions()->pluck( 'name' )->toArray();
                @endphp
                <div class="role-box view-role-{{ $role->id }}">
                    <div class="d-flex justify-content-between mb-3">
                        <p class="mb-0 text-light-black fs-20 fw-bold">{{ $role->name }}</p>
                        <div class="d-flex align-items-center">
                            @if($role->name !== 'admin')
                                <span class="delete me-3"
                                      data-id="{{ $role->id }}"
                                      data-action="{{ route('roles.destroy',$role->id) }}"
                                      onclick="deleteConfirmation({{$role->id}})">
                                    <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span
                                    class="path3"></span><span class="path4"></span></span>
                                </span>
                                <button class="edit-btn h-32 inline-flex-center" onclick="editRoleView({{ $role->id }});">
                                    {{ __('messages.edit') }}
                                    <span class="icon-edit ms-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <p class="text-light-black mgb-32">
                        {{ $role->description ?? '' }}
                    </p>
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
                <form id="updateRole">
                    <div class="role-box role-edit-{{ $role->id }} d-none">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="max-w-424 mgb-32">
                                <div class="mgb-20">
                                    <input type="text" id="updateName" class="dashboard-input w-100" value="{{ $role->name }}"
                                           placeholder="Name here...">
                                    <p class="text-danger updateNameErrorMsg"></p>
                                </div>
                                <textarea id="updateDescription" class="dashboard-textarea w-100" id="" cols="30" rows="2"
                                          placeholder="Description here..."> {{ $role->description }} </textarea>
                                <p class="text-danger updateDescriptionErrorMsg"></p>
                            </div>
                        </div>
                        @foreach($permissions as $permission)
                            <div class="d-flex permission-check flex-wrap">
                                <p class="mb-0 fw-bold text-light-black permission"><span
                                            class="text-capitalize">{{ $permission }}</span>
                                    {{ __('messages.role_view.permission') }}</p>
                                @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                                    <div class="checkbox-group">
                                        <input type="checkbox" class="checkbox-input edit-data-{{ $role->id }}"
                                               name="update_permission_{{ $role->id }}"
                                               data-name="{{ $permission_type . '.' . $permission }}"
                                               data-model-name="{{ $permission }}"
                                               value="{{ $permission_type . '.' . $permission }}"
                                               @if(in_array($permission_type. '.' . $permission, $permission_list)) checked
                                                @endif>
                                        <label for="" class="checkbox-label text-capitalize">{{ $permission_type }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="text-end">
                            <button class="button button-primary h-32 py-1 px-4">{{ __('messages.update') }}</button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
@endsection

@push("js")
    <script>
        $(document).ready(function () {
            $('.new-role').hide();
        });

        function showNewRoleCreate() {
            $('.new-role').toggle();
        }

        $('#createRole').on('submit', function (e) {
            $('.createNameErrorMsg').text('');
            $('.createDescriptionErrorMsg').text('');
            e.preventDefault();

            let role_name = $('#createName').val();
            let role_description = $('#createDescription').val();
            let role_permissions = [];
            $("input:checkbox[name='create_permission']:checked").each(function () {
                role_permissions.push($(this).val());
            });

            $.ajax({
                url: "{{ route('roles.store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: role_name,
                    description: role_description,
                    permissions: role_permissions
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    let errors = response.responseJSON.errors;
                    $('.createNameErrorMsg').text(errors.name);
                    $('.createDescriptionErrorMsg').text(errors.description);
                },
            });
        });
        $('.updateRole').on('submit', function (e) {
            $('.updateNameErrorMsg').text('');
            $('.updateDescriptionErrorMsg').text('');
            e.preventDefault();

            let role_name = $('#updateName').val();
            let role_description = $('#updateDescription').val();
            let role_permissions = [];
            $("input:checkbox[name='update_permission']:checked").each(function () {
                role_permissions.push($(this).val());
            });

            $.ajax({
                url: "{{ route('roles.store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: role_name,
                    description: role_description,
                    permissions: role_permissions
                },
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    let errors = response.responseJSON.errors;
                    $('.createNameErrorMsg').text(errors.name);
                    $('.createDescriptionErrorMsg').text(errors.description);
                },
            });
        });

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

        $(document).on("click", ".check-data", function () {
            let all_siblings = $(".check-data");
            let self = $(this);
            let name = self.data('name');
            let model_name = self.data('model-name');
            let view_select;
            if (name.includes('.' + model_name)) {
                view_select = checkView(name, self);
                if (view_select) {
                    enableCheck(all_siblings, "view." + model_name);
                }
            }
        });

        /**
         * Check if data select on view.
         *
         * @param name
         * @param self
         * @returns {boolean}
         */
        function checkView(name, self) {
            if (name.includes('view')) {
                $(self).prop('checked', $(self).is(":checked"));

                return false;
            }

            return true;
        }

        /**
         * Select view auto if select
         * create, update, delete.
         *
         * @param all_siblings
         * @param viewName
         */
        function enableCheck(all_siblings, viewName) {
            all_siblings.each((ele) => {
                let item = all_siblings[ele];
                let name = $(item).data('name');
                if (name === viewName) {
                    $(item).prop('checked', true);
                }
            });
        }

        function editRoleView(role_id) {
            $('.role-edit-' + role_id).removeClass('d-none');
            $('.view-role-' + role_id).addClass('d-none');
        }
    </script>
@endpush
