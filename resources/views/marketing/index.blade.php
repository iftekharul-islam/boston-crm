@extends('layouts.app')
@section('content')
    <marketing-list :clients="{{ $clients }}" :statuses="{{ $statuses }}" :categories="{{ $categories }}" :users="{{ $users }}"></marketing-list>
@endsection
