@extends('layouts.app')

@section('content')
   <call-list :filter-value="{{ json_encode($filterValue) }}" :order="{{ json_encode($order) }}" :appraisers="{{ $appraisers }}"></call-list>
 @endsection
