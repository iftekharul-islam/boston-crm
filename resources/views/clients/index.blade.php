@extends('layouts.app')
@section('content')
    @php
        $owner = $is_owner ? 'true' : 'false'
    @endphp
    <clients-list :permissions="{{ json_encode($user_permissions) }}" :is-owner="{{ $owner }}" :role="'{{ $user_role }}'" :show-route="'{{ route('clients.show', [""]) }}'" :create-route="'{{ route('clients.create') }}'" :delete-route="'{{ route('clients.destroy', [""]) }}'"></clients-list>
@endsection
