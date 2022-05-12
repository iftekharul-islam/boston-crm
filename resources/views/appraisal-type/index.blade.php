@extends('layouts.app')

@section('content')
    <div class="clients bg-platinum dashboard-space">
        <div class="clients-box user-box clients-box-main bg-white">
            <div class="clients-top d-flex flex-wrap justify-content-between">
                <p class="mb-0 text-light-black fs-20 text-600">Appraisal Types</p>
                <a href="{{ route('appraisal-types.create') }}" class="button button-primary">Create appraisal type</a>
            </div>
            <div class="clients-table user-table mt-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Form Type</th>
                        <th scope="col">Modified Form</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appraisal_types ?? [] as $appraisal_type)
                        <tr>
                            <td>{{ $appraisal_type->form_type }}</td>
                            <td>{{ $appraisal_type->modified_form }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($is_owner || in_array('update.appraisaltype', $user_permissions))
                                        <a href="{{ route('appraisal-types.edit', $appraisal_type->id) }}" class="me-3 text-light-black cursor-pointer">
                                        <span class="icon-edit fs-20"><span class="path1"></span><span
                                                    class="path2"></span></span></a>
                                    @endif
                                    @if($is_owner || in_array('delete.appraisaltype', $user_permissions))
                                        <a class="cursor-pointer text-light-black" data-id="{{ $appraisal_type->id }}"
                                           data-action="{{ route('appraisal-types.destroy',$appraisal_type->id) }}"
                                           onclick="deleteConfirmation({{$appraisal_type->id}})"> <span
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
            @if ($appraisal_types->hasPages())
                <div class="pagination-wrapper">
                    {{ $appraisal_types->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection

@section('js')
    <script>
        /**
         * User delete id.
         *
         * @param id
         */
        function deleteConfirmation(id) {
            let url = '{{ route("appraisal-types.destroy", ":id") }}';
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
                        },
                        error: function (results) {
                            swal("Error!", results.responseJSON.message, "error").then(function () {
                                    location.reload();
                                }
                            );
                        },
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
