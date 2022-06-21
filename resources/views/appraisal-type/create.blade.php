@extends('layouts.app')

@section('content')
<div class="bg-platinum dashboard-space">
    <div class="add-appraiser bg-white pd-32 br-8">
        <div class="bg-platinum max-w-488 pd-32 br-8">
            <form id="appraiser-type-form" action="{{ route('appraisal-types.store') }}" method="POST">
                <h4 class="fs-20 fw-bold mb-3">Add appraisal type</h4>
                @csrf

                <div class="form-group group">
                    <label for="exampleInputEmail1">Form type</label>
                    <input type="text" name="form_type"
                        class="dashboard-input w-100 @error('form_type') is-invalid @enderror" id="formType"
                        placeholder="Enter form type" value="{{ old('form_type') }}">
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
                        placeholder="Enter modified form" value="{{ old('modified_form') }}">
                    @error('modified_form')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <p class="mgb-12">Condo type</p>
                    <div class="d-flex condo-type">
                        <div class="position-relative mgr-32">
                            <input type="radio" name="condo_type" value="1"
                                class="@error('condo_type') is-invalid @enderror condo-type-input" id="condo_type"
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
                <div class="form-group mt-4">
                    <p class="mgb-12">Is full Appraisal</p>
                    <input type="radio" id="yes" name="is_full_appraisal" value="1">
                    <label for="yes">Yes</label>
                    <input type="radio" id="no" name="is_full_appraisal" value="0">
                    <label for="no">No</label><br>
                </div>
                <div class="text-end mgt-32">
                    <button type="button" id="submit-button" class="button button-primary h-40 py-2 px-5">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(function () {
        $('#submit-button').on('click', function (e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            $('#appraiser-type-form').submit();
        });
    });
</script>
@endpush
