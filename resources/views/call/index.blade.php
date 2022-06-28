@extends('layouts.app')

@section('content')
   <call-list :order="{{ json_encode($order) }}"></call-list>
 @endsection
