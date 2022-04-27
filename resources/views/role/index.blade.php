@extends('layouts.app')

@section('content')
    <div class="role-permission bg-platinum dashboard-space">
        <div class="d-flex justify-content-between">
            <p class="mb-0 text-light-black fs-20 fw-bold">{{ __('messages.role_view.role_management') }}</p>
            <button class="button button-primary" onclick="showNewRoleCreate();"
                    role="button">{{ __('messages.role_view.role_create') }}</button>
        </div>
        {{-- role create--}}
        @include('role._create-role')
        {{-- role preview --}}
        <div class="role-preview">
            @foreach($roles ?? [] as $key => $role)
                @php
                    $permission_list = $role->permissions()->pluck( 'name' )->toArray();
                @endphp
                @include('role._view-role')
                @include('role._edit-role')
            @endforeach
        </div>
    </div>
@endsection

@push("js")
    <script>
        $(document).ready(function () {
            $('.new-role').addClass('d-none');
        });

        function showNewRoleCreate() {
            $('.new-role').removeClass('d-none');
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

        /**
         *
         * @param role_id
         */
        function editRoleView(role_id) {
            $('.role-edit-' + role_id).removeClass('d-none');
            $('.view-role-' + role_id).addClass('d-none');
        }

        /**
         * Role update by id.
         *
         * @param role_id
         */
        function updateRole(role_id) {
            $('.updateNameErrorMsg' + role_id).text('');
            $('.updateDescriptionErrorMsg' + role_id).text('');

            let role_name = $('#updateName' + role_id).val();
            let role_description = $('#updateDescription' + role_id).val();
            let role_permissions = [];
            $("input:checkbox[name='update_permission_" + role_id + "']:checked").each(function () {
                role_permissions.push($(this).val());
            });
            let url = '{{ route("roles.update", ":id") }}';
            url = url.replace(':id', role_id);

            $.ajax({
                url: url,
                type: "PUT",
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
                    $('.updateNameErrorMsg' + role_id).text(errors.name);
                    $('.updateDescriptionErrorMsg' + role_id).text(errors.description);
                },
            });
        }

        /**
         * Delete role by id.
         *
         * @param id
         */
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
                        url: "{{ url('/roles') }}/" + id,
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

        /**
         * New role checkbox active or inactive
         */
        function newCreateRoleCheck() {
            $(document).on("click", ".check-data", function () {
                let all_siblings = $(".check-data");
                let self = $(this);
                selectedCheckActiveOrInactive(all_siblings, self)
            });
        }

        /**
         *
         * @param role_id
         */
        function editRoleCheck(role_id) {
            $(document).on("click", ".check-data-" + role_id, function () {
                let all_siblings = $(".check-data-" + role_id);
                let self = $(this);
                selectedCheckActiveOrInactive(all_siblings, self)
            });
        }

        /**
         *
         * @param all_siblings
         * @param self
         */
        function selectedCheckActiveOrInactive(all_siblings, self) {
            let name = self.data('name');
            let model_name = self.data('model-name');
            let model_list = ["create." + model_name, "update." + model_name, "delete." + model_name];
            let view_select;
            if (name.includes('.' + model_name)) {
                view_select = checkView(name, self, all_siblings, model_list);
                if (view_select && $(self).is(':checked')) {
                    enableCheck(all_siblings, "view." + model_name);
                }
            }
        }

        /**
         * Check if data select on view.
         *
         * @param name
         * @param self
         * @param all_siblings
         * @param model_name
         * @returns {boolean}
         */
        function checkView(name, self, all_siblings, model_name) {
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
                    $(item).prop('disabled', true);
                }
            });
        }
    </script>
@endpush
