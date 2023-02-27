@extends('layouts.app')

@section('content')
    <div class="bg-platinum dashboard-space">
        <div class="add-appraiser bg-white pd-32 br-8">
            <div class="bg-platinum max-w-488 pd-32 br-8">
                <form action="{{ route('loan-types.update', $loan_type->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group group">
                        <label class="d-block" for="exampleInputEmail1">Loan type</label>
                        <input type="text"
                               name="name"
                               class="dashboard-input w-100 @error('name') is-invalid @enderror"
                               id="name"
                               placeholder="Enter loan type"
                               value="{{ $loan_type->name }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group mb-2 mt-2">
                        <label for="exampleInputEmail1">Is FHA :</label>
                        <div class="mgb-32 d-flex align-items-center mt-2">
                            <div class="checkbox-group review-check mgr-20">
                                <input type="radio" class="checkbox-input check-data" name="is_fha" value="1" {{ $loan_type->is_fha == 1 ? 'checked' : '' }}>
                                <label for="" class="checkbox-label text-capitalize">Yes</label>
                            </div>
                            <div class="checkbox-group review-check">
                                <input type="radio" class="checkbox-input check-data" name="is_fha" value="0" {{ $loan_type->is_fha == 0 ? 'checked' : '' }}>
                                <label for="" class="checkbox-label text-capitalize">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mgt-32">
                        <button type="submit" class="button button-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
