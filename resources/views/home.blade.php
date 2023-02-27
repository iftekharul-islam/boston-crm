@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('roles.index') }}" class="btn btn-info" role="button">Role List</a>
        <a href="{{ route('users.index') }}" class="btn btn-info" role="button">User List</a>
    </div>
@endsection
