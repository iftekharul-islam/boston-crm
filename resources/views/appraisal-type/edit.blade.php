@extends('layouts.app')

@section('content')
<div class="bg-platinum dashboard-space">
    <div class="add-appraiser bg-white pd-32 br-8">
        <div class="bg-platinum max-w-488 pd-32 br-8">
            <form action="{{ route('appraisal-types.update', $appraisal_type->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group group">
                    <label for="exampleInputEmail1">Form type</label>
                    <input type="text" name="form_type" class="dashboard-input w-100 @error('form_type') is-invalid @enderror"
                        id="formType" placeholder="Enter form type" value="{{ $appraisal_type->form_type }}">
                    @error('form_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group group">
                    <label for="exampleInputEmail1">Modified Form</label>
                    <input type="text" name="modified_form"
                        class="dashboard-input w-100 @error('modified_form') is-invalid @enderror" id="modifiedForm"
                        placeholder="Enter modified form" value="{{ $appraisal_type->modified_form }}">
                    @error('modified_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group group">
                    <p class="mgb-12">Condo type</p>
                    <div class="d-flex condo-type">
                        <div class="position-relative mgr-32">
                            <input type="checkbox" @if($appraisal_type->modified_form == 1 ) checked @endif
                        name="condo_type" value="1" class="@error('condo_type') is-invalid @enderror condo-type-input" id="condo_type"
                        value="{{ old('condo_type') }}">
                            <label for="condo_type" class="condo-type-label"> Yes </label>
                        </div>
                        <div class="position-relative">
                            <input type="radio" name="condo_type" value="2" id="condo_type2" class="condo-type-input">
                            <label for="condo_type2" class="condo-type-label"> No</label>
                        </div>
                    </div>
                    @error('condo_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group group">
                    <p class="mgb-12">Is full Appraisal</p>
                    <div class="d-flex condo-type">
                        <div class="position-relative mgr-32">
                            <input type="radio" @if($appraisal_type->is_full_appraisal == 1)
                                checked @endif id="yes" name="is_full_appraisal" value="1" class="condo-type-input" >
                            <label for="yes" class="condo-type-label">Yes</label>
                        </div>
                        <div class="position-relative">
                            <input type="radio" @if($appraisal_type->is_full_appraisal == 0)
                                checked @endif id="no" name="is_full_appraisal" value="0" class="condo-type-input" >
                            <label for="no" class="condo-type-label">No</label>
                        </div>
                    </div>
                </div>
                <div class="mgt-32 text-end">
                    <button type="submit" class="button button-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
