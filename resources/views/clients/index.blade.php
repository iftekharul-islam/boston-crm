@extends('layouts.app')
@section('content')
    <clients-list :permissions="{{ json_encode($user_permissions) }}" :isOwner="{{ $is_owner }}" :role="'{{ $user_role }}'" :show-route="'{{ route('clients.show', [""]) }}'" :create-route="'{{ route('clients.create') }}'" :delete-route="'{{ route('clients.destroy', [""]) }}'"></clients-list>
@endsection
