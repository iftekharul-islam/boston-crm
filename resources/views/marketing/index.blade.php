@extends('layouts.app')
@section('content')
    <marketing-list :clients="{{ $clients }}"></marketing-list>
@endsection
