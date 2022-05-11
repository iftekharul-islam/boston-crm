@extends('layouts.app')
@section('content')
    <div class="order-details bg-platinum dashboard-space">
        <a href="{{ url('/order') }}" class="text-light-black d-inline-flex align-items-center mgb-20">
            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.57086 5.18001C9.76086 5.18001 9.95086 5.25 10.1009 5.4C10.3909 5.69 10.3909 6.17 10.1009 6.46L4.56086 12L10.1009 17.54C10.3909 17.83 10.3909 18.31 10.1009 18.6C9.81086 18.89 9.33086 18.89 9.04086 18.6L2.97086 12.53C2.68086 12.24 2.68086 11.76 2.97086 11.47L9.04086 5.4C9.19086 5.25 9.38086 5.18 9.57086 5.18001Z" fill="#2F415E"/>
                <path d="M3.67 11.25L20.5 11.25C20.91 11.25 21.25 11.59 21.25 12C21.25 12.41 20.91 12.75 20.5 12.75L3.67 12.75C3.26 12.75 2.92 12.41 2.92 12C2.92 11.59 3.26 11.25 3.67 11.25Z" fill="#2F415E"/>
            </svg>
            Back to order list</a>
        <div class="order-details-box-main row">

            <div class="order-details__left col-md-6">
                {{-- Basic Information --}}
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Basic Information</p>
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="list__group">
                            <p class="mb-0 left-side">Property address  </p>
                            <span>:</span>
                            <p class="right-side mb-0 text-primary fw-bold fs-20">1453 Dorchester Ave, Boston, Ma 02122</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Due date</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Order no</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Order receive date</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                    </div>
                </div>
                 {{-- Borrower --}}
                 <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Borrower</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="list__group">
                            <p class="mb-0 left-side">Borrower name</p>
                            <span>:</span>
                            <p class="right-side mb-0">John Doe</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Co-borrower name</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Phone</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Email</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                    </div>
                </div>
                 {{-- Contact --}}
                 <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Contact</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="list__group">
                            <p class="mb-0 left-side">Contact name</p>
                            <span>:</span>
                            <p class="right-side mb-0">John Doe</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Phone</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Email</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Address</p>
                            <span>:</span>
                            <p class="right-side mb-0">1453 Dorchester Ave, Boston, 
                                Ma 02122</p>
                        </div>
                    </div>
                </div>
                   {{-- Inspection --}}
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Inspection</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="list__group">
                            <p class="mb-0 left-side">Appraiser II</p>
                            <span>:</span>
                            <p class="right-side mb-0">John Doe</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Inspection date</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Notes</p>
                            <span>:</span>
                            <p class="right-side mb-0 line-1">Amar sonar bangla ami tomai valoabashi, chirodin tomar akash chirodin tomar akash chirodin tomar akash</p>
                        </div>
                    </div>
                </div>
                 {{-- Issues --}}
                 <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Issues/ Queries/ Tickets</p>
                        <a href="" class="d-inline-flex edit add-call align-items-center fw-bold">Add issue</a>
                    </div>
                    <div class="box-body">
                        <div class="queries-row" >
                            <div class="queries-box position-relative pending">
                                <span class="badges pending-badges">Pending</span>
                                <p class="text-gray text-end mgb-12">Today 12:10am</p>
                                <p class="text-light-black">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between mgb-12">
                                    <a href="#" class="text-gray mb-0 underline">Assigned to : <span class="text-light-black text-600">Technical team</span></a>
                                    <a href="#" class="share-box">
                                        <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                    </a>
                                </div>
                            </div>
                            <div class="queries-box position-relative pending" >
                                <span class="badges pending-badges">Pending</span>
                                <p class="text-gray text-end mgb-12">Today 12:10am</p>
                                <p class="text-light-black">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between mgb-12">
                                    <a href="#" class="text-gray mb-0">Assigned to : <span class="text-light-black text-600">Technical team</span></a>
                                    <a href="#" class="share-box">
                                        <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                    </a>
                                </div>
                            </div>
                            <div class="queries-box position-relative solved">
                                <span class="badges solved-badges">Pending</span>
                                <p class="text-gray text-end mgb-12">Today 12:10am</p>
                                <p class="text-light-black">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between mgb-12">
                                    <a href="#" class="text-gray mb-0">Assigned to : <span class="text-light-black text-600">Technical team</span></a>
                                    <a href="#" class="share-box">
                                        <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                                    </a>
                                </div>
                                <div class="solution">
                                    <p class="mb-1 fs-14 ">Solution:</p>
                                    <p class="mb-0 fs-14">Amar sonar bangla ami tomai valobashi.
                                        Chirodin tomar akash tomar batash amar prane
                                        bajai bashi sonar bangla ami tomai valobashi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-details__right col-md-6">
                  {{-- Appraisal Details --}}
                  <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Appraisal Details</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="list__group">
                            <p class="mb-0 left-side">Appraisal Type</p>
                            <span>:</span>
                            <p class="right-side mb-0">John Doe</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Appraiser Name</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Client Order #</p>
                            <span>:</span>
                            <p class="right-side mb-0">25 Jun 2022</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Loan #</p>
                            <span>:</span>
                            <p class="right-side mb-0">1453 Dorchester Ave, Boston, 
                                Ma 02122</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Loan Type </p>
                            <span>:</span>
                            <p class="right-side mb-0">1453 Dorchester Ave, Boston, 
                                Ma 02122</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">FHA Case</p>
                            <span>:</span>
                            <p class="right-side mb-0">1453 Dorchester Ave, Boston, 
                                Ma 02122</p>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Appraisal Fee </p>
                            <span>:</span>
                            <p class="right-side mb-0">1453 Dorchester Ave, Boston, 
                                Ma 02122</p>
                        </div>
                    </div>
                </div>
                {{-- Client --}}
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Client</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="list mb-3">
                            <div class="list__group mb-3">
                                <p class="mb-0 left-side">AMC name</p>
                                <span>:</span>
                                <p class="right-side mb-0">EStreet Appraisal Management
                                    Company, LLC</p>
                            </div>
                            <a href="#" class="underline text-primary text-600">AMC requirements</a>
                        </div>
                        <div class="list__group">
                            <p class="mb-0 left-side">Lender/ Bank name</p>
                            <span>:</span>
                            <p class="right-side mb-0">NEWREZ LLC</p>
                        </div>
                        <div class="list">
                            <div class="list__group mb-3">
                                <p class="mb-0 left-side">AMC name</p>
                                <span>:</span>
                                <p class="right-side mb-0">EStreet Appraisal Management
                                    Company, LLC</p>
                            </div>
                            <a href="#" class="underline text-primary text-600">AMC requirements</a>
                        </div>
                    </div>
                </div>
                {{-- Call log --}}
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Call log</p>
                        <a href="" class="d-inline-flex edit add-call align-items-center fw-bold">Add call log</a>
                    </div>
                    <div class="box-body">
                        <div class="col-log">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Caller name</th>
                                        <th scope="col">Call date & time</th>
                                        <th scope="col">Message</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Sandy Rock</td>
                                        <td>12.02.2022  3:45 pm</td>
                                        <td>I have called and left a message</td>
                                        <td><router-link to="/" class="message">
                                                <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                            </router-link></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Sandy Rock</td>
                                        <td>12.02.2022  3:45 pm</td>
                                        <td>I have called and left a message</td>
                                        <td><router-link to="/" class="message">
                                                <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                            </router-link></td>
                                    </tr>
                                    <tr>
                                        <td>1.</td>
                                        <td>Sandy Rock</td>
                                        <td>12.02.2022  3:45 pm</td>
                                        <td>I have called and left a message</td>
                                        <td><router-link to="/" class="message">
                                                <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                                            </router-link></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Map --}}
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Map</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d423286.2817730339!2d-118.69260188474334!3d34.02015975940636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2sbd!4v1650253099882!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                 
            </div>
        </div>
        <div class="row">
            <div class="order-details__left col-md-8">
                   Workflow
                  <div class="order-details-box bg-white h-100">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Workflow</p>
                        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                    </div>
                    <div class="box-body">
                        <div class="workflow-content">
                             step list
                            <div class="list">
                                <div class="item complete">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
                                    <p class="mb-0">Order Creation</p>
                                </div>
                                <div class="item current">
                                    <span class="ball"><img src="/img/current.png" alt="current step boston"></span>
                                    <p class="mb-0">Order Creation</p>
                                </div>
                                <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
                                    <p class="mb-0">Order Creation</p>
                                </div>
                                <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
                                    <p class="mb-0">Order Creation</p>
                                </div>
                                <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
                                    <p class="mb-0">Order Creation</p>
                                </div>
                                <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
                                    <p class="mb-0">Order Creation</p>
                                </div>
                            </div>
                             step item
                            <div class="step-item pe-3">
                                 Inspection
                                <div class="inspection-item">
                                    <div class="top-bar">
                                        <button class="item active">Assign</button>
                                        <button class="item">Writing complete?</button>
                                        <button class="item">Add note</button>
                                    </div>
                                    <div class="item-body">
                                        <div class="mgb-32">
                                            <label for="" class="mb-2 text-light-black d-inline-block">Writer</label>
                                            <div class="right-scedule w-100 position-relative">
                                                <select name="" id="" class="w-100 dashboard-input">
                                                    <option value="">Hello</option>
                                                    <option value="">Hello</option>
                                                </select>
                                                <span class="icon-arrow-down bottom-arrow-icon"></span>
                                            </div>
                                        </div>
                                        <div class="mgb-32">
                                            <label for="" class="mb-2 text-light-black d-inline-block">Writer</label>
                                            <div class="right-scedule w-100 position-relative">
                                                <select name="" id="" class="w-100 dashboard-input">
                                                    <option value="">Hello</option>
                                                    <option value="">Hello</option>
                                                </select>
                                                <span class="icon-arrow-down bottom-arrow-icon"></span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="button button-primary px-5">Save</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-details__right col-md-4">
                  Appraisal Details
                 <div class="order-details-box bg-white h-100">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">History</p>

                    </div>
                    <div class="box-body">
                        <p class="mb-3 text-light-black">Order Created by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">Scheduled by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">Inspected by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">prepared by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">Initially Reviewed by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">Report Analysed and Reviewed by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">Quality Assured by: <span class="text-600 text-light-black">Toushi</span></p>
                        <p class="mb-3 text-light-black">Delivered by: <span class="text-600 text-light-black">Toushi</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mgt-32">
            <div class="row ">
                <div class="col-12">
                     Files
                    <div class="order-details-box bg-white">
                        <div class="box-header">
                            <p class="fw-bold text-light-black fs-20 mb-0">Files</p>
                            <div class="group">
                                <div class="position-relative file-upload document-upload">
                                    <input type="file">
                                    <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                             document
                            <div class="document">
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
                                        <p class="fw-bold text-light-black">Report <span class="text-danger">*</span></p>
                                        <div>
                                            <p class="text-gray">Didnt add yet</p>
                                            <div class="position-relative file-upload report-upload">
                                                <input type="file">
                                                <label for="">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                                            </div>
                                        </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="note-grid">
                       Invoice
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Activity log</p>
                        <a href="" class="d-inline-flex edit add-call align-items-center fw-bold">Add invoice</a>
                    </div>
                    <div class="box-body">
                        <div class="invoice-table">
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
                    </div>
                </div>
                 Note
                <div class="order-details-box bg-white">
                    <div class="box-header">
                        <p class="fw-bold text-light-black fs-20 mb-0">Notes</p>
                    </div>
                    <div class="box-body">
                       <div class="note-chat">
                            item chat
                            <div class="chat-item">
                                <div class="chat-name d-flex align-items-center">
                                    <img src="/img/dummy-profile.png" alt="boston chat image" class="img-fluid">
                                    <div class="ms-3">
                                        <p class="text-600 mb-1">Mahfuz</p>
                                        <span class="text-gray">Section 1</span>
                                    </div>
                                </div>
                                 chat
                                <div class="d-inline-block message">
                                    <p class="mb-0 ">Kmon achen vaiya?</p>
                                </div>
                            </div>
                             item chat
                            <div class="chat-item">
                                <div class="chat-name d-flex align-items-center">
                                    <img src="/img/dummy-profile.png" alt="boston chat image" class="img-fluid">
                                    <div class="ms-3">
                                        <p class="text-600 mb-1">Mofiz</p>
                                        <span class="text-gray">Section 1</span>
                                    </div>
                                </div>
                                 chat
                                <div class="d-inline-block message">
                                    <p class="mb-0 ">Valo nai re vai . ki korbo kichui bujtachina , valo lagena dunia dari. jai hok tor ki obostha</p>
                                </div>
                            </div>
                             item chat
                            <div class="chat-item">
                                <div class="chat-name d-flex align-items-center">
                                    <img src="/img/dummy-profile.png" alt="boston chat image" class="img-fluid">
                                    <div class="ms-3">
                                        <p class="text-600 mb-1">Mahfuz</p>
                                        <span class="text-gray">Section 1</span>
                                    </div>
                                </div>
                                 chat
                                <div class="d-inline-block message">
                                    <p class="mb-0 ">Kmon achen vaiya?</p>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
             Activity log
            <div class="order-details-box bg-white">
                <div class="box-header">
                    <p class="fw-bold text-light-black fs-20 mb-0">Activity log</p>
                </div>
                <div class="box-body">
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                    <p class="fs-14 mgb-20">Order Added - Nowid - 08-20-2020 10:00 AM</p>
                </div>
            </div>
            </div>
        </div>
        {{-- modal --}}
        <div class="modal order-details-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <h4 class="text-600 fs-20 mgb-24">Edit Basic Information</h4>

                  <div class="group">
                      <label for="" class="d-block mb-2 dashboard-label">Email <span class="require"></span></label>
                      <input type="email" name="email" id="email" class="dashboard-input w-100">
                  </div>
                  <div class="group">
                      <label for="role" class="d-block text-light-black mb-2">Zip code <span class="require"></span></label>
                      <div class="position-relative">
                          <select name="role" id="role" class="dashboard-input w-100">
                              <option value="">Please select role</option>
                              <option value="3" class="text-capitalize"> admin</option>
                               <option value="4" class="text-capitalize"> inkasd</option>
                          </select>
                          <span class="icon-arrow-down bottom-arrow-icon"></span>
                      </div>
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-2 dashboard-label">Received date  <span class="text-danger require"></span></label>
                       <div class="position-relative">
                         <input type="date" class="dashboard-input w-100">
                         <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                       </div>
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-2 dashboard-label">Lender address <span class="require"></span></label>
                        <textarea name="textarea" class="dashboard-input dashboard-textarea w-100"> </textarea>
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-2 dashboard-label">Lender address <span class="require"></span></label>
                        <div class="link-group d-flex">
                            <input type="text" class="dashboard-input w-100 me-3">
                            <button class="link-btn py-2 h-40 button button-primary">Copy</button>
                        </div>
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-2 dashboard-label">Email address <span class="text-danger require"></span></label>
                        <input type="text" class="dashboard-input w-100">
                        <div class=" mgt-12">
                            <button class="add-more ">
                                <span class="icon-plus"></span>  Add more
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="button button-transparent" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="button button-primary px-5">Save</button>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
<script>
    import BasicInfo from "../../js/components/orders/details/basicInfo";
    export default {
        components: {BasicInfo}
    }
</script>
