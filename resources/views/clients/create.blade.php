@extends('layouts.app')
@section('content')
    @push('css')
        <style>
            label.required::after {
                content: '*';
                margin-right: 4px;
                color: red;
            }
        </style>
    @endpush
    <div class="add-order">
        <div class="d-flex align-items-center justify-content-between">
            <p>Add new Client</p>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-8">
                <div class="form-box">
                    <h4 class="box-header mb-3">Appraisal details</h4>
                    <div class="d-flex justify-content-between w-100">
                        <form id="client-form" action="{{ route('clients.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="left max-w-424 w-100 me-3">
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label required">Client Name</label>
                                    <input type="text" name="name" class="dashboard-input w-100" required placeholder="Enter Client Name">
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label required">Email</label>
                                    <input type="text" name="email" id="email" class="dashboard-input w-100" required placeholder="Enter Email">
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label required">Phone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Enter phone number" required class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="client-type" class="d-block mb-2 dashboard-label required">Client Type</label>
                                    <div class="position-relative">
                                        <select name="client_type" id="client-type" class="dashboard-input w-100" required>
                                            <option value="">Select Client Type</option>
                                            <option value="amc">AMC</option>
                                            <option value="lender">Lender</option>
                                        </select>
                                        <img src="bottom-arrow.png" alt="" class="bottom-arrow">
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="address" class="d-block mb-2 dashboard-label address-label">Address</label>
                                    <input type="text" name="address" id="address" placeholder="Enter address" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="city" class="d-block mb-2 dashboard-label city-label">City</label>
                                    <input type="text" name="city" id="city" placeholder="Enter city" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="state" class="d-block mb-2 dashboard-label state-label">State</label>
                                    <input type="text" name="state" id="state" placeholder="Enter state" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="zip" class="d-block mb-2 dashboard-label zip-label">Zip</label>
                                    <input type="text" name="zip" id="zip" placeholder="Enter zip" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="country" class="d-block mb-2 dashboard-label country-label">Country</label>
                                    <input type="text" name="country" id="country" placeholder="Enter Country" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="deducts-technology-fee" class="d-block mb-2 dashboard-label deducts-technology-fee-label">Deducts Technology Fee ?</label>
                                    <div class="position-relative">
                                        <select name="deducts_technology_fee" id="deducts-technology-fee" class="dashboard-input w-100">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <img src="bottom-arrow.png" alt="" class="bottom-arrow">
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="fee-for-1004UAD" class="d-block mb-2 dashboard-label fee-for-1004UAD-label">Technology Fee For Full Appraisal Like 1004UAD</label>
                                    <input type="text" name="fee_for_1004uad" id="fee-for-1004UAD" placeholder="Enter Amount" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="fee-for-1004D" class="d-block mb-2 dashboard-label fee-for-1004D-label">Technology Fee For Partial Appraisal Like 1004D</label>
                                    <input type="text" name="fee_for_1004d" id="fee-for-1004D" placeholder="Enter Amount" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="can-sign" class="d-block mb-2 dashboard-label can-sign-label">Trainee Can Sign<span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <select name="can_sign" id="can-sign" class="dashboard-input w-100">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <img src="bottom-arrow.png" alt="" class="bottom-arrow">
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="can-inspect" class="d-block mb-2 dashboard-label can-inspect-label">Trainee Can Inspect<span class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <select name="can_inspect" id="can-inspect" class="dashboard-input w-100">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        <img src="bottom-arrow.png" alt="" class="bottom-arrow">
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="instruction" class="d-block mb-2 dashboard-label">Client Instruction AS PDF FIle</label>
                                    <input type="file" name="instruction" id="instruction" class="dashboard-input w-100" />
                                </div>

                                <button type="submit" class="btn btn-primary" id="submit">Create Client</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $('#client-type').on('change',function(e){
            e.preventDefault();
            let clientType = $(this).val();
            if(clientType === 'lender'){
                $(".address-label, .city-label, .state-label, .country-label, .zip-label").addClass('required');
            }else{
                $(".deducts-technology-fee-label, .fee-for-1004UAD-label, .fee-for-1004D-label, .can-sign-label .can-inspect")
            }
        });
    </script>
@endpush
