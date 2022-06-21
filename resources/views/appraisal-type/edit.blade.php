@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 mx-auto">
            <form action="{{ route('appraisal-types.update', $appraisal_type->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label for="exampleInputEmail1">Form type</label>
                    <input type="text" name="form_type" class="form-control @error('form_type') is-invalid @enderror"
                        id="formType" placeholder="Enter form type" value="{{ $appraisal_type->form_type }}">
                    @error('form_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Modified Form</label>
                    <input type="text" name="modified_form"
                        class="form-control @error('modified_form') is-invalid @enderror" id="modifiedForm"
                        placeholder="Enter modified form" value="{{ $appraisal_type->modified_form }}">
                    @error('modified_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <label for="condo_type">
                        <input type="checkbox" @if($appraisal_type->modified_form == 1 ) checked @endif
                        name="condo_type" value="1" class="@error('condo_type') is-invalid @enderror" id="condo_type"
                        value="{{ old('condo_type') }}">
                        Condo Type
                    </label>
                    @error('condo_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <p class="mgb-12">Is full Appraisal</p>
                    <input type="radio" @if($appraisal_type->is_full_appraisal == 1)
                            checked @endif id="yes" name="is_full_appraisal" value="1">
                    <label for="yes">Yes</label>
                    <input type="radio" @if($appraisal_type->is_full_appraisal == 0)
                            checked @endif id="no" name="is_full_appraisal" value="0">
                    <label for="no">No</label><br>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
