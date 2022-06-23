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
                    <div class="text-end mgt-32">
                        <button type="submit" class="button button-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
