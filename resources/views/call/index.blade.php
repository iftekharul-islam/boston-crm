@extends('layouts.app')

@section('content')
   <call-list :order="{{ json_encode($order) }}" :appraisers="{{ $appraisers }}"></call-list>
 @endsection
