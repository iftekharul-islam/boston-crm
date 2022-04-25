@extends('layouts.app')

@section('content')
  <div class="clients bg-platinum dashboard-space">
    <div class="clients-box user-box clients-box-main bg-white">
      <div class="clients-top d-flex flex-wrap justify-content-between">
          <p class="mb-0 text-light-black fs-20 text-600">User management</p>
        <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="button button-primary"
        role="button">{{ __('messages.user_view.user_create') }}</button>
      </div>
      <div class="clients-table user-table mt-4">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">{{ __('messages.user_view.user_name') }}</th>
                <th scope="col">{{ __('messages.user_view.user_email') }}</th>
                <th scope="col">{{ __('messages.user_view.role') }}</th>
                <th scope="col">{{ __('Percentage') }}</th>
                <th scope="col">{{ __('Phone') }}</th>
                <th scope="col">{{ __('messages.user_view.join_date') }}</th>
                <th scope="col">{{ __('Address') }}</th>
                <th scope="col">{{ __('messages.status') }}</th>
                <th scope="col">{{ __('messages.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users ?? [] as $key => $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="role-name"> {{ $user->getUserRole($user->id, $company->id) }}</span> <span class="icon-edit fs-20"><span class="path1"></span><span class="path2"></span></span></td>
                    <td><span class="role-name">50%</span>  <span class="icon-edit fs-20"><span class="path1"></span><span class="path2"></span></span></td>
                    <td>012562546521</td>
                    <td>{{ $user->pivot->join_date }}</td>
                    <td>16 River St - Unit 16 Quincy...</td>
                    <td>{{ $user->pivot->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a class="me-3 text-light-black cursor-pointer" href="{{ route('users.edit', $user->id) }}">
                                <span class="icon-edit fs-20"><span class="path1"></span><span class="path2"></span></span></a>

                                <a class="cursor-pointer text-light-black" data-id="{{ $user->id }}"
                                    data-action="{{ route('users.destroy',$user->id) }}"
                                    onclick="deleteConfirmation({{$user->id}})"> <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
                        </div>

                        {{-- @if($company->owner_id !== $user->id)
                            <div class="d-flex align-items-center">
                                <a class="me-3" href="{{ route('users.edit', $user->id) }}">
                                    <span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
                                <a class="" data-id="{{ $user->id }}"
                                   data-action="{{ route('users.destroy',$user->id) }}"
                                   onclick="deleteConfirmation({{$user->id}})"> <span class="icon-trash"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
                            </div>
                        @endif --}}
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
    <!-- Modal -->
    <div class="modal fade user-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="user-dialog modal-dialog modal-dialog-centered">
        <div class="modal-content user-content">
            <h4 class="mgb-32 fw-bold fs-20">Add user</h4>
            <div class="modal-body p-0 mgb-24">
                <div class="group">
                    <label for="" class="d-block text-light-black mb-2">Role name</label>
                    <div class="position-relative">
                        <select name="" id="" class="login-input w-100">
                            <option value="">Admin</option>
                            <option value="">Admin</option>
                            <option value="">Admin</option>
                        </select>
                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                    </div>
                </div>
                <div class="group">
                    <label for="" class="d-block mb-2 dashboard-label">Email address</label>
                    <input type="email" class="login-input w-100">
                </div>
            </div>
            <div class="footer d-flex align-items-center justify-content-end">
            <button type="button" class="button button-transparent" data-bs-dismiss="modal">Close</button>
            <button type="button" class="button button-primary px-5 py-2 h-40">Invite</button>
            </div>
        </div>
        </div>
    </div>
  </div>



@endsection

@section('js')
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
                        url: "{{url('/users')}}/" + id,
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
