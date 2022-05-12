@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 mx-auto">
                <form action="{{ route('loan-types.update', $loan_type->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-2">
                        <label for="exampleInputEmail1">Loan type</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               placeholder="Enter loan type"
                               value="{{ $loan_type->name }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
