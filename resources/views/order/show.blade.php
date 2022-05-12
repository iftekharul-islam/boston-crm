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

            <basic-info></basic-info>
            <appraisal-details></appraisal-details>

        </div>
        <div class="row">
            <workflow></workflow>
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


    </div>
@endsection
<script>
    import BasicInfo from "../../js/components/orders/details/basicInfo";
    export default {
        components: {BasicInfo}
    }
</script>
