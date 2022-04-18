@extends('layouts.home.app')
@section('content')
    <div class="clients bg-platinum dashboard-space">
        <div class="clients-box add-client bg-white">
           <div class="add-client-form">
            <p class="text-light-black fs-20 mgb-16">Add new client</p>
                <div class="row">
                    <div class="col-lg-8 left mb-3">
                        <div class="d-flex box justify-content-between left__wrap">
                            <div class="left-side max-w-424 w-100 me-3">
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Cleient name <span class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Client type <span class="text-danger require"></span></label>
                                    <div class="position-relative">
                                        <select name="" id="" class="dashboard-input w-100">
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                        </select>
                                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Client URL <span class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Address <span class="text-danger require"></span></label>
                                    <textarea name="" class="dashboard-textarea w-100" id="" cols="30" rows="2"></textarea>
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Email address <span class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100">
                                    <div class="text-end mgt-20">
                                        <button class="add-more ">
                                            <span class="icon-plus"></span>  Add more
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- right side --}}
                            <div class="right-side max-w-424 w-100">
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Ciry  <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">State <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Zip code <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Country <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Phone no <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                        <div class="text-end mgt-20">
                                            <button class="add-more ">
                                                <span class="icon-plus"></span>  Add more
                                            </button>
                                        </div>
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Fax no <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 right mb-3">
                        <div class="box">
                            <div class="max-w-424 w-100">
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Technology fee for full appraisal like 1004UAD</label>
                                    <input type="text" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Technology fee for full appraisal like 1004UAD</label>
                                    <input type="text" class="dashboard-input w-100">
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Deduction of tech fee during payment </label>
                                    <div class="position-relative">
                                        <select name="" id="" class="dashboard-input w-100">
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                        </select>
                                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Trainee can sign </label>
                                    <div class="position-relative">
                                        <select name="" id="" class="dashboard-input w-100">
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                        </select>
                                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Trainee can inspect </label>
                                    <div class="position-relative">
                                        <select name="" id="" class="dashboard-input w-100">
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                            <option value="">Loan</option>
                                        </select>
                                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                                    </div>
                                </div>
                                <div class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">Trainee can inspect </label>
                                    <div class="position-relative file-upload">
                                        <input type="file">
                                        <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
           <div class="add-client__bottom d-flex justify-content-end mgt-32 p-3">
            <button class="button button-discard me-3">Discard <span class="icon-close-circle ms-3"><span class="path1"></span><span class="path2"></span></span></button>
            <button class="button button-primary">Add client</button>
        </div>
        </div>
        
    </div>
@endsection
