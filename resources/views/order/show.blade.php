@extends('layouts.app')
@section('content')
    <div class="order-details bg-platinum dashboard-space">
        <a href="{{ url('/order') }}" class="text-light-black d-inline-flex align-items-center mgb-20">
            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.57086 5.18001C9.76086 5.18001 9.95086 5.25 10.1009 5.4C10.3909 5.69 10.3909 6.17 10.1009 6.46L4.56086 12L10.1009 17.54C10.3909 17.83 10.3909 18.31 10.1009 18.6C9.81086 18.89 9.33086 18.89 9.04086 18.6L2.97086 12.53C2.68086 12.24 2.68086 11.76 2.97086 11.47L9.04086 5.4C9.19086 5.25 9.38086 5.18 9.57086 5.18001Z" fill="#2F415E"/>
                <path d="M3.67 11.25L20.5 11.25C20.91 11.25 21.25 11.59 21.25 12C21.25 12.41 20.91 12.75 20.5 12.75L3.67 12.75C3.26 12.75 2.92 12.41 2.92 12C2.92 11.59 3.26 11.25 3.67 11.25Z" fill="#2F415E"/>
            </svg>
            Back to order list</a>
        <div class="order-details-box bg-white">
            {{-- top bar --}}
            <div class="order-details-top d-flex flex-wrap align-items-start justify-content-between mgb-32">
                <div class="left">
                    <h2 class="fs-20 mgb-26">Order name:<span class="text-primary fw-bold">1453 Dorchester Ave, Boston, Ma 02122</span> </h2>
                    <div class="d-flex list__group">
                        <p class="mb-0 left-side">Property address</p>
                        <span></span>
                        <p class="mb-0 right-side">1453 Dorchester Ave, Boston, Ma 02122</p>
                    </div>
                </div>
                <div class="right d-flex align-items-center">
                    <p class="mb-0 text-light-black">Current status</p>
                    <div class="right-scedule position-relative mx-4">
                        <select name="" id="" class="w-100 dashboard-input">
                            <option value="">Hello</option>
                            <option value="">Hello</option>
                        </select>
                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                    </div>
                    <div class="">
                        <a href="" class="right-edit text-light-black">Edit order <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                </div>
            </div>
            {{-- details --}}
            <div class="order-details-list row">
                <div class="left col-lg-4">
                    <div class="list__group">
                        <p class="mb-0 left-side">Appraiser fee  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Appraiser fee (5%) </p>
                        <span>:</span>
                        <p class="right-side mb-0">$150.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Order no</p>
                        <span>:</span>
                        <p class="right-side mb-0">451263582</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Client order no </p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Order receive date</p>
                        <span>:</span>
                        <p class="right-side mb-0">25 Jan 2022</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Appraiser type</p>
                        <span>:</span>
                        <p class="right-side mb-0">1004 Single family</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Appraiser name</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Loan order</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Loan type </p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">FHA case</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Contact name</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Phone</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Email</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Address</p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                </div>
                <div class="middle col-lg-4">
                    <div class="list__group">
                        <p class="mb-0 left-side">Company name  </p>
                        <span>:</span>
                        <p class="right-side mb-0">EStreet Appraisal Management
                            Company, LLC</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Contact name  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Company address  </p>
                        <span>:</span>
                        <p class="right-side mb-0">	6021 Wallace Rd Ext#202; Wexford
                            Pennsylvania 15090</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Lender/ Bank name  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Lender address  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Phone  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Email  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>

                    <a href="" class="text-primary mgb-32 d-inline-block">Lender requirements</a>
                    <div class="group">
                        <label for="" class="d-block mb-2 dashboard-label">Assigned to </label>
                        <div class="position-relative">
                            <select name="" id="" class="dashboard-input w-100">
                                <option value="">Loan</option>
                                <option value="">Loan</option>
                                <option value="">Loan</option>
                            </select>
                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                        </div>
                    </div>
                </div>
                <div class="right col-lg-4">
                    <div class="list__group">
                        <p class="mb-0 left-side">Appraiser fee  </p>
                        <span>:</span>
                        <p class="right-side mb-0">$300.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Appraiser fee (5%) </p>
                        <span>:</span>
                        <p class="right-side mb-0">$150.00</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Order no</p>
                        <span>:</span>
                        <p class="right-side mb-0">451263582</p>
                    </div>
                    <div class="list__group">
                        <p class="mb-0 left-side">Client order no </p>
                        <span>:</span>
                        <p class="right-side mb-0">Amrock</p>
                    </div>
                </div>
            </div>
            {{-- call log --}}
            <div class="col-log bg-platinum pd-20 br-8">
                <h4 class="box-header mb-3">Call log</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">User name</th>
                            <th scope="col">Call date & time</th>
                            <th scope="col">Inspector</th>
                            <th scope="col">Appraiser</th>
                            <th scope="col">Message</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Sandy Rock</td>
                            <td>12.02.2022  3:45 pm</td>
                            <td>Fahim Rahman</td>
                            <td>Asadur Rahman</td>
                            <td>I have called and left a message</td>
                            <td><router-link to="/" class="message">
                                    <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                </router-link></td>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Sandy Rock</td>
                            <td>12.02.2022  3:45 pm</td>
                            <td>Fahim Rahman</td>
                            <td>Asadur Rahman</td>
                            <td>I have called and left a message</td>
                            <td><router-link to="/" class="message">
                                    <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                </router-link></td>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Sandy Rock</td>
                            <td>12.02.2022  3:45 pm</td>
                            <td>Fahim Rahman</td>
                            <td>Asadur Rahman</td>
                            <td>I have called and left a message</td>
                            <td><router-link to="/" class="message">
                                    <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                </router-link></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- order tabs --}}
            <div class="d-flex order-tabs">
                {{-- tabs button --}}
                <div class="order-tabs-menu nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link " id="v-pills-order-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order" type="button" role="tab" aria-controls="v-pills-order" aria-selected="true">Orders <span class="icon-arrow-down ms-auto"></span></button>
                    <button class="nav-link" id="v-pills-inspection-tab" data-bs-toggle="pill" data-bs-target="#v-pills-inspection" type="button" role="tab" aria-controls="v-pills-inspection" aria-selected="false">Inspection <span class="icon-arrow-down ms-auto"></span></button>
                    <button class="nav-link active" id="v-pills-report-preparation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-report-preparation" type="button" role="tab" aria-controls="v-pills-report-preparation" aria-selected="false">Report preparation & review <span class="icon-arrow-down ms-auto"></span></button>
                    <button class="nav-link" id="v-pills-value-review-tab" data-bs-toggle="pill" data-bs-target="#v-pills-value-review" type="button" role="tab" aria-controls="v-pills-value-review" aria-selected="false">Value reviewing (US) <span class="icon-arrow-down ms-auto"></span></button>
                    <button class="nav-link" id="v-pills-quality-review-tab" data-bs-toggle="pill" data-bs-target="#v-pills-quality-review" type="button" role="tab" aria-controls="v-pills-quality-review" aria-selected="false">Quality review (BNT) <span class="icon-arrow-down ms-auto"></span></button>
                    <button class="nav-link" id="v-pills-submission-tab" data-bs-toggle="pill" data-bs-target="#v-pills-submission" type="button" role="tab" aria-controls="v-pills-submission" aria-selected="false">Submission <span class="icon-arrow-down ms-auto"></span></button>
                    <button class="nav-link" id="v-pills-revision-tab" data-bs-toggle="pill" data-bs-target="#v-pills-revision" type="button" role="tab" aria-controls="v-pills-revision" aria-selected="false">Revision <span class="icon-arrow-down ms-auto"></span></button>
                </div>
                {{-- tabs content --}}
                <div class="tab-content order-tabs-content" id="v-pills-tabContent">
                    {{-- order --}}
                    <div class="tab-pane fade " id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">...</div>
                    {{-- inspection --}}
                    <div class="tab-pane fade" id="v-pills-inspection" role="tabpanel" aria-labelledby="v-pills-inspection-tab">...</div>
                    {{-- report-preparation --}}
                    <div class="tab-pane fade show active" id="v-pills-report-preparation" role="tabpanel" aria-labelledby="v-pills-report-preparation-tab">
                        <div class="report-preparation-tabs">
                            <ul class="nav nav-pills mb-3 tabs-list" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-assign-tab" data-bs-toggle="pill" data-bs-target="#pills-assign" type="button" role="tab" aria-controls="pills-assign" aria-selected="true">Assign</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-writing-tab" data-bs-toggle="pill" data-bs-target="#pills-writing" type="button" role="tab" aria-controls="pills-writing" aria-selected="false">Writing complete?</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-note-tab" data-bs-toggle="pill" data-bs-target="#pills-note" type="button" role="tab" aria-controls="pills-note" aria-selected="false">Add note</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                {{-- assign --}}
                                <div class="tab-pane fade show active" id="pills-assign" role="tabpanel" aria-labelledby="pills-assign-tab">
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Writer </label>
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
                                        <label for="" class="d-block mb-2 dashboard-label">Reviewer from BD </label>
                                        <div class="position-relative">
                                            <select name="" id="" class="dashboard-input w-100">
                                                <option value="">Loan</option>
                                                <option value="">Loan</option>
                                                <option value="">Loan</option>
                                            </select>
                                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                                        </div>
                                    </div>
                                </div>
                                {{-- writing --}}
                                <div class="tab-pane fade" id="pills-writing" role="tabpanel" aria-labelledby="pills-writing-tab">...</div>
                                {{-- add note --}}
                                <div class="tab-pane fade" id="pills-note" role="tabpanel" aria-labelledby="pills-note-tab">...</div>
                            </div>
                        </div>
                    </div>
                    {{-- value-review --}}
                    <div class="tab-pane fade" id="v-pills-value-review" role="tabpanel" aria-labelledby="v-pills-value-review-tab">...</div>
                    {{-- quality-review --}}
                    <div class="tab-pane fade" id="v-pills-quality-review" role="tabpanel" aria-labelledby="v-pills-quality-review-tab">...</div>
                    {{-- submission --}}
                    <div class="tab-pane fade" id="v-pills-submission" role="tabpanel" aria-labelledby="v-pills-submission-tab">...</div>
                    {{-- revision --}}
                    <div class="tab-pane fade" id="v-pills-revision" role="tabpanel" aria-labelledby="v-pills-revision-tab">...</div>
                </div>
            </div>

            {{-- order map --}}
            <div class="order-map">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="box-header mb-3">Order messages</h4>
                        <div class="d-flex flex-wrap order-map-checkbox mb-3">
                            <div class="group checkbox-group dark-checkbox position-relative">
                                <input type="checkbox" class=" checkbox-input w-100">
                                <label for="" class="checkbox-label">Email alert</label>
                            </div>
                            <div class="group checkbox-group dark-checkbox position-relative">
                                <input type="checkbox" class=" checkbox-input w-100">
                                <label for="" class="checkbox-label">Call log</label>
                            </div>
                            <div class="group checkbox-group dark-checkbox position-relative">
                                <input type="checkbox" class=" checkbox-input w-100">
                                <label for="" class="checkbox-label">Email to borrower</label>
                            </div>
                            <div class="group checkbox-group dark-checkbox position-relative">
                                <input type="checkbox" class=" checkbox-input w-100">
                                <label for="" class="checkbox-label">Show to client</label>
                            </div>

                        </div>
                        {{-- chat box --}}
                        <h2 class="text-center ">Chat here</h2>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="box-header mb-3">Order messages</h4>
                        <div class="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d423286.2817730339!2d-118.69260188474334!3d34.02015975940636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2sbd!4v1650253099882!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            {{-- document  --}}
            <div class="document">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="box-header mb-3">Documents</h4>
                    </div>
                    <div class="col-sm-6 document-file d-flex justify-content-end">
                        <a href="" class="d-inline-flex align-items-center jutify-content-center gray-border bdr-1 br-4 document-file-folder me-3">
                            Your folder
                            <img src="/img/folder.svg" alt="boston profile" class="img-fluid ms-3">

                        </a>
                        <div class="group">
                            <div class="position-relative file-upload">
                                <input type="file">
                                <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <p class="fw-bold text-light-black">Inspection</p>
                        <div class="d-flex align-items-center mb-3">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <p class="fw-bold text-light-black">Order</p>
                        <div class="d-flex align-items-center mb-3">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <p class="mb-0 text-gray">Didnt add yet</p>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <p class="fw-bold text-light-black">Other</p>
                        <div class="d-flex align-items-center mb-3">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- invoice --}}
            <div class="invoice invoice-border">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="invoice-table mgb-48">
                            <div class="d-flex justify-content-between">
                                <h4 class="box-header mb-0">Invoices</h4>
                                <a href="#" class="text-light-black underline"><span class="icon-plus me-2"></span> Create invoice</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">Invoice no</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Invoice amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>INV33654</td>
                                        <td>01, Jan, 2022</td>
                                        <td>12.02.2022  3:45 pm</td>
                                        <td>Unpaid</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="comments-table mgb-48">
                            <div class="d-flex justify-content-between">
                                <h4 class="box-header mb-0">Comments</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Date & time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Comment</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>01, Jan, 2022</td>
                                        <td>On hold</td>
                                        <td>Hold</td>
                                        <td>
                                            <a href="" class="max-w-200 d-inline-block text-accepted">
                                                Waiting fo...
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="comments-table">
                            <div class="d-flex justify-content-between">
                                <h4 class="box-header mb-0">Re-Schedule / Delete History</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Date & time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Reason</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>01, Jan, 2022</td>
                                        <td>	Schedule Removed</td>
                                        <td><a href="#" class="max-w-200 d-inline-block text-accepted">
                                                Initially appointment
                                                12/04/2020 at 12:00 pm. Orde...</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <h4 class="box-header mgb-20">Invoices</h4>
                        <div class="feed">
                            <p class="feed-list text-light-black">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                            <p class="feed-list text-light-black">Called the Borrower - Ryan - 08-20-2020 11:00 AM</p>
                            <p class="feed-list text-light-black">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                            <p class="feed-list text-light-black">Called the Borrower - Ryan - 08-20-2020 11:00 AM</p>
                            <p class="feed-list text-light-black">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                            <p class="feed-list text-light-black">Called the Borrower - Ryan - 08-20-2020 11:00 AM</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- queries section --}}
            <div class="queries-section mgt-24">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="box-header mgb-20">Invoices</h4>
                        <a href="#" class="bdr-1 gray-border br-4 px-4 py-2 inline-flex-center text-light-black">Schedule now</a>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="box-header mgb-20">Invoices</h4>
                        <div class="d-flex">
                            <textarea name="" id="" rows="2" class="flex-grow-1 bdr-1 gray-border br-4 h-64 mgr-14"></textarea>
                            <button class="bg-primary w-64 bdr-1 primary-border br-4 text-white inline-flex-center">Post</button>
                        </div>
                        {{--  --}}
                        <div class=" queries-row mgt-24" >
                            <div class="queries-box position-relative pending">
                                <span class="badges pending-badges">Pending</span>
                                <p class="text-gray text-end mgb-12">Today 12:10am</p>
                                <p class="text-light-black">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between">
                                    <p class="text-gray mb-0">Assigned to : <span class="text-light-black">Technical team</span></p>
                                    <a href="#" class="share-box">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.9569 0.833252H4.9319C4.59023 0.833252 4.3069 1.11659 4.3069 1.45825C4.3069 1.79992 4.59023 2.08325 4.9319 2.08325H7.44857L1.01523 8.51659C0.773568 8.75825 0.773568 9.15825 1.01523 9.39992C1.14023 9.52492 1.29857 9.58325 1.4569 9.58325C1.61523 9.58325 1.77357 9.52492 1.89857 9.39992L8.3319 2.96659V5.48325C8.3319 5.82492 8.61524 6.10825 8.9569 6.10825C9.29857 6.10825 9.5819 5.82492 9.5819 5.48325V1.45825C9.5819 1.11659 9.29857 0.833252 8.9569 0.833252Z" fill="#F97373"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="queries-box position-relative pending" >
                                <span class="badges pending-badges">Pending</span>
                                <p class="text-gray text-end mgb-12">Today 12:10am</p>
                                <p class="text-light-black">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between">
                                    <p class="text-gray mb-0">Assigned to : <span class="text-light-black">Technical team</span></p>
                                    <a href="#" class="share-box">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.9569 0.833252H4.9319C4.59023 0.833252 4.3069 1.11659 4.3069 1.45825C4.3069 1.79992 4.59023 2.08325 4.9319 2.08325H7.44857L1.01523 8.51659C0.773568 8.75825 0.773568 9.15825 1.01523 9.39992C1.14023 9.52492 1.29857 9.58325 1.4569 9.58325C1.61523 9.58325 1.77357 9.52492 1.89857 9.39992L8.3319 2.96659V5.48325C8.3319 5.82492 8.61524 6.10825 8.9569 6.10825C9.29857 6.10825 9.5819 5.82492 9.5819 5.48325V1.45825C9.5819 1.11659 9.29857 0.833252 8.9569 0.833252Z" fill="#F97373"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="queries-box position-relative solved">
                                <span class="badges solved-badges">Pending</span>
                                <p class="text-gray text-end mgb-12">Today 12:10am</p>
                                <p class="text-light-black">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between">
                                    <p class="text-gray mb-0">Assigned to : <span class="text-light-black">Technical team</span></p>
                                    <a href="#" class="share-box">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.9569 0.833252H4.9319C4.59023 0.833252 4.3069 1.11659 4.3069 1.45825C4.3069 1.79992 4.59023 2.08325 4.9319 2.08325H7.44857L1.01523 8.51659C0.773568 8.75825 0.773568 9.15825 1.01523 9.39992C1.14023 9.52492 1.29857 9.58325 1.4569 9.58325C1.61523 9.58325 1.77357 9.52492 1.89857 9.39992L8.3319 2.96659V5.48325C8.3319 5.82492 8.61524 6.10825 8.9569 6.10825C9.29857 6.10825 9.5819 5.82492 9.5819 5.48325V1.45825C9.5819 1.11659 9.29857 0.833252 8.9569 0.833252Z" fill="#F97373"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
