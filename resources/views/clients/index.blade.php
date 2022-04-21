@extends('layouts.home.app')
@section('content')
    <clients-list :show-route="'{{ route('clients.show', [""]) }}'" :create-route="'{{ route('clients.create') }}'" :delete-route="'{{ route('clients.destroy', [""]) }}'"></clients-list>
@endsection
