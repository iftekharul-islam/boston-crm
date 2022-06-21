@extends('layouts.app')

@section('content')
    <div class="bg-platinum dashboard-space">
        <div class="add-appraiser bg-white pd-32 br-8">
            <div class="bg-platinum max-w-488 pd-32 br-8">
                <form id="loan-type-form" action="{{ route('loan-types.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="exampleInputEmail1">Loan type</label>
                        <input type="text" name="name" class="dashboard-input w-100 @error('name') is-invalid @enderror"
                               id="name" placeholder="Enter loan type" value="{{ old('name') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
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
    $(function() {
        $('#submit-button').on('click',function(e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            $('#loan-type-form').submit();
        });
    });
</script>
@endpush
