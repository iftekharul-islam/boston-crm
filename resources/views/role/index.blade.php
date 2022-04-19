@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <a href="{{ route('roles.create') }}" class="btn btn-info" role="button">Role Create</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Role Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles ?? [] as $key => $role)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if($role->name !== 'admin')
                            <div class="d-flex align-items-center">
                                <a class="mr-2" href="{{ route('roles.edit', $role->id) }}">
                                    <i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-flat btn-sm remove-user ms-2" data-id="{{ $role->id }}"
                                   data-action="{{ route('roles.destroy',$role->id) }}"
                                   onclick="deleteConfirmation({{$role->id}})"> <i class="fa fa-trash"></i></a>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push("scripts")
    <script>
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
