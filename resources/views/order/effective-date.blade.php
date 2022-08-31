@extends('layouts.app')
@section('content')
    <effective-date :appraisers="{{ $appraisers }}" :orders="{{ $orders }}"></effective-date>
@endsection
