@extends('layouts.home.app')

@section('content')
    <div class="container mt-2">
        <a href="{{ route('users.create') }}" class="btn btn-info"
           role="button">{{ __('messages.user_view.user_create') }}</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">{{ __('messages.user_view.user_name') }}</th>
                <th scope="col">{{ __('messages.user_view.user_email') }}</th>
                <th scope="col">{{ __('messages.user_view.role') }}</th>
                <th scope="col">{{ __('messages.user_view.join_date') }}</th>
                <th scope="col">{{ __('messages.status') }}</th>
                <th scope="col">{{ __('messages.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users ?? [] as $key => $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getUserRole($user->id, $company->id) }}</td>
                    <td>{{ $user->pivot->join_date }}</td>
                    <td>{{ $user->pivot->status ? 'Active' : 'Inactive' }}</td>
                    <td>
                        @if($company->owner_id !== $user->id)
                            <div class="d-flex align-items-center">
                                <a class="mr-2" href="{{ route('users.edit', $user->id) }}">
                                    <i class="fa fa-edit"></i></a>
                                <a class="btn btn-danger btn-flat btn-sm remove-user ms-2" data-id="{{ $user->id }}"
                                   data-action="{{ route('users.destroy',$user->id) }}"
                                   onclick="deleteConfirmation({{$user->id}})"> <i class="fa fa-trash"></i></a>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if ($users->hasPages())
            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
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
