@extends('layouts.app')
@section('content')
    <div class="order-add bg-platinum dashboard-space">
        <div class="order-add-box bg-white">
            <div class="order-add-box__form">
                <div class="d-flex align-items-center justify-content-between">
                    <p>Add new order</p>
                    <div class="step">
                        <button class="step-btn pointer ">Step 1</button>
                        <button class="step-btn active">Step 2</button>
                    </div>
                </div>
                {{--  --}}
                <div class="row mgb-32">
                    <div class="col-md-12 ">
                        <div class="form-box">
                            <h4 class="box-header mb-3">Borrower info</h4>
        
                            <div class="d-flex justify-content-between w-100">
                                <div class="left max-w-424 w-100 me-3">
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Borrower name <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Co-borrower name</label>
                                        <input type="text" class="dashboard-input w-100">
                                    </div>
                                </div>
                                <div class="middle max-w-424 w-100 me-3">
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Contact no <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                        <div class="text-end mgt-20">
                                            <button class="add-more ">
                                                <span class="icon-plus"></span>  Add more
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="right max-w-424 w-100">
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
                            </div>
                        </div>
        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="form-box">
                            <h4 class="box-header mb-3">Contact info</h4>
        
                            <div class="d-flex justify-content-between w-100">
                                <div class="left max-w-424 w-100 me-3">
                                    <div class="group checkbox-group position-relative">
                                        <input type="checkbox" class=" checkbox-input w-100">
                                        <label for="" class="checkbox-label text-primary">Set borrower as contact</label>
                                    </div>
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Contact <span class="text-danger require"></span></label>
                                        <textarea name="" class="dashboard-textarea w-100" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="middle max-w-424 w-100 me-3">
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Contact no <span class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100">
                                        <div class="text-end mgt-20">
                                            <button class="add-more ">
                                                <span class="icon-plus"></span>  Add more
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="right max-w-424 w-100">
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
                            </div>
                        </div>
        
                    </div>
                </div>
                <div class="group mgt-32">
                    <h4 class="box-header mb-3">Upload order form</h4>
                    <div class="position-relative file-upload">
                        <input type="file">
                        <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
                    </div>
                </div>
            </div>
            <div class="add-client__bottom d-flex justify-content-end  p-3">
                <button class="button button-discard me-3 d-flex align-items-center">Discard <span class="icon-close-circle ms-3"><span class="path1"></span><span class="path2"></span></span></button>
                <button class="button button-primary"> Add order </button>
            </div>
        </div>
    </div>
@endsection
