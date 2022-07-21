@extends('layouts.app')
@section('content')
    <marketing-list :clients="{{ $clients }}" :statuses="{{ $statuses }}"></marketing-list>
@endsection
