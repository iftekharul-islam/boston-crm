@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('appraisal-types.store') }}" method="POST">
            @csrf

            <div class="form-group mb-2">
                <label for="exampleInputEmail1">Form type</label>
                <input type="text" name="form_type" class="form-control" id="formType" placeholder="Enter form type" value="{{ old('form_type') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Modified Form</label>
                <input type="text" name="modified_form" class="form-control" id="modifiedForm"
                       placeholder="Enter modified form" value="{{ old('modified_form') }}">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
@endsection
