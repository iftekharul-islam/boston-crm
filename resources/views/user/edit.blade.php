@extends('layouts.home.app')

@section('content')
    <div class="container">
        <div class="col-md-4 col-md-offset-6 m-auto">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">User Name</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="roleHelp"
                           placeholder="Enter user name" value="{{ $user->name ?? old('name') }}" readonly>
                    @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">User Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="roleHelp"
                           placeholder="Enter user email" value="{{ $user->email ?? old('email') }}" readonly>
                    @if($errors->has('email'))
                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                    @else
                        <small id="roleHelp" class="form-text text-muted">Please avoid duplicate email</small>
                    @endif
                </div>
                <div class="form-group mb-2">
                    <label for="userRole">User Role</label>
                    <select class="crm-select form-control" name="role" id="userRole" required>
                        <option value="">Please select role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" @if($role->id === $company_user->role_id) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
