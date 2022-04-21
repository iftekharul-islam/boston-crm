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
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5574 4.35829C16.2157 4.22496 14.8741 4.12496 13.5241 4.04996V4.04163L13.3407 2.95829C13.2157 2.19163 13.0324 1.04163 11.0824 1.04163H8.89907C6.95741 1.04163 6.77407 2.14163 6.64074 2.94996L6.46574 4.01663C5.69074 4.06663 4.91574 4.11663 4.14074 4.19163L2.44074 4.35829C2.09074 4.39163 1.84074 4.69996 1.87407 5.04163C1.90741 5.38329 2.20741 5.63329 2.55741 5.59996L4.25741 5.43329C8.62407 4.99996 13.0241 5.16663 17.4407 5.60829C17.4657 5.60829 17.4824 5.60829 17.5074 5.60829C17.8241 5.60829 18.0991 5.36663 18.1324 5.04163C18.1574 4.69996 17.9074 4.39163 17.5574 4.35829Z" fill="#2F415E"/>
                            <path opacity="0.3991" d="M16.0264 6.78337C15.8264 6.57504 15.5514 6.45837 15.2681 6.45837H4.73475C4.45142 6.45837 4.16809 6.57504 3.97642 6.78337C3.78475 6.99171 3.67642 7.27504 3.69309 7.56671L4.20975 16.1167C4.30142 17.3834 4.41809 18.9667 7.32642 18.9667H12.6764C15.5848 18.9667 15.7014 17.3917 15.7931 16.1167L16.3098 7.57504C16.3264 7.27504 16.2181 6.99171 16.0264 6.78337Z" fill="#2F415E"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.98438 14.1666C7.98438 13.8214 8.2642 13.5416 8.60937 13.5416H11.3844C11.7296 13.5416 12.0094 13.8214 12.0094 14.1666C12.0094 14.5118 11.7296 14.7916 11.3844 14.7916H8.60937C8.2642 14.7916 7.98438 14.5118 7.98438 14.1666Z" fill="#2F415E"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29297 10.8334C7.29297 10.4882 7.57279 10.2084 7.91797 10.2084H12.0846C12.4298 10.2084 12.7096 10.4882 12.7096 10.8334C12.7096 11.1786 12.4298 11.4584 12.0846 11.4584H7.91797C7.57279 11.4584 7.29297 11.1786 7.29297 10.8334Z" fill="#2F415E"/>
                        </svg>                            
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
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5574 4.35829C16.2157 4.22496 14.8741 4.12496 13.5241 4.04996V4.04163L13.3407 2.95829C13.2157 2.19163 13.0324 1.04163 11.0824 1.04163H8.89907C6.95741 1.04163 6.77407 2.14163 6.64074 2.94996L6.46574 4.01663C5.69074 4.06663 4.91574 4.11663 4.14074 4.19163L2.44074 4.35829C2.09074 4.39163 1.84074 4.69996 1.87407 5.04163C1.90741 5.38329 2.20741 5.63329 2.55741 5.59996L4.25741 5.43329C8.62407 4.99996 13.0241 5.16663 17.4407 5.60829C17.4657 5.60829 17.4824 5.60829 17.5074 5.60829C17.8241 5.60829 18.0991 5.36663 18.1324 5.04163C18.1574 4.69996 17.9074 4.39163 17.5574 4.35829Z" fill="#2F415E"/>
                            <path opacity="0.3991" d="M16.0264 6.78337C15.8264 6.57504 15.5514 6.45837 15.2681 6.45837H4.73475C4.45142 6.45837 4.16809 6.57504 3.97642 6.78337C3.78475 6.99171 3.67642 7.27504 3.69309 7.56671L4.20975 16.1167C4.30142 17.3834 4.41809 18.9667 7.32642 18.9667H12.6764C15.5848 18.9667 15.7014 17.3917 15.7931 16.1167L16.3098 7.57504C16.3264 7.27504 16.2181 6.99171 16.0264 6.78337Z" fill="#2F415E"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.98438 14.1666C7.98438 13.8214 8.2642 13.5416 8.60937 13.5416H11.3844C11.7296 13.5416 12.0094 13.8214 12.0094 14.1666C12.0094 14.5118 11.7296 14.7916 11.3844 14.7916H8.60937C8.2642 14.7916 7.98438 14.5118 7.98438 14.1666Z" fill="#2F415E"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29297 10.8334C7.29297 10.4882 7.57279 10.2084 7.91797 10.2084H12.0846C12.4298 10.2084 12.7096 10.4882 12.7096 10.8334C12.7096 11.1786 12.4298 11.4584 12.0846 11.4584H7.91797C7.57279 11.4584 7.29297 11.1786 7.29297 10.8334Z" fill="#2F415E"/>
                        </svg>                            
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
