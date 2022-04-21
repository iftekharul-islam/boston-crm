@extends('layouts.app')

@section('content')
    <div class="role-permission bg-platinum dashboard-space">
       <div class="d-flex justify-content-between">
           <p class="mb-0 text-light-black fs-20 fw-bold">Role manangement</p>
            <a href="{{ route('roles.create') }}" class="button button-primary" role="button">Role Create</a>
       </div>
       {{-- role preview --}}
       <div class="role-preview">
        <div class="role-box">
            <div class="d-flex justify-content-between mb-3">
                <p class="mb-0 text-light-black fs-20 fw-bold">Executive</p>
                <div class="d-flex align-items-center">
                    <span class="delete me-3">
                        <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>                           
                    </span>
                    <a href="#" class="edit-btn h-32 inline-flex-center">
                        Edit
                        <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span>
                    </a>
                </div>
            </div>
            <p class="text-light-black mgb-32">First, you add your personal and professional information using a simple editor.</p>
            <div class="d-flex permission-check flex-wrap">
                <p class="mb-0 fw-bold text-light-black permission">User permission</p>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">View</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Contact</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Update</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Delete</label>
                </div>
            </div>
            <div class="d-flex permission-check flex-wrap">
                <p class="mb-0 fw-bold text-light-black permission">Order permission</p>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">View</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Contact</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Update</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Delete</label>
                </div>
                
            </div>
        </div>
       </div>
       {{-- role create--}}
       <div class="role-add mgt-32">
           <div class="role-box">
               <div class="d-flex align-items-start justify-content-between">
                    <div class="max-w-424 mgb-32">
                        <div class="mgb-20">
                            <input type="text" class="dashboard-input w-100 " placeholder="Name here...">
                        </div>
                        <textarea name="" class="dashboard-textarea w-100" id="" cols="30" rows="2" placeholder="Description here..."></textarea>
                    </div>
                    <span class="delete">
                        <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>                            
                    </span>
                </div>
               <div class="d-flex permission-check flex-wrap">
                    <p class="mb-0 fw-bold text-light-black permission">User permission</p>
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox-input">
                        <label for="" class="checkbox-label">View</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox-input">
                        <label for="" class="checkbox-label">Contact</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox-input">
                        <label for="" class="checkbox-label">Update</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox-input">
                        <label for="" class="checkbox-label">Delete</label>
                    </div>
                </div>

            <div class="d-flex permission-check flex-wrap">
                <p class="mb-0 fw-bold text-light-black permission">Order permission</p>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">View</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Contact</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Update</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input">
                    <label for="" class="checkbox-label">Delete</label>
                </div>
            </div>
            <div class="text-end">
                <button class="button button-primary h-32 py-1 px-4">Save</button>
            </div>
            </div>
       </div>

        {{-- <table class="table">
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
        </table> --}}
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
