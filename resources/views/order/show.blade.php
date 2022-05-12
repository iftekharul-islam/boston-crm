@extends('layouts.app')
@section('content')
    <div class="order-details bg-platinum dashboard-space">
        <a href="{{ url('/order') }}" class="text-light-black d-inline-flex align-items-center mgb-20">
            <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.57086 5.18001C9.76086 5.18001 9.95086 5.25 10.1009 5.4C10.3909 5.69 10.3909 6.17 10.1009 6.46L4.56086 12L10.1009 17.54C10.3909 17.83 10.3909 18.31 10.1009 18.6C9.81086 18.89 9.33086 18.89 9.04086 18.6L2.97086 12.53C2.68086 12.24 2.68086 11.76 2.97086 11.47L9.04086 5.4C9.19086 5.25 9.38086 5.18 9.57086 5.18001Z"
                      fill="#2F415E"/>
                <path d="M3.67 11.25L20.5 11.25C20.91 11.25 21.25 11.59 21.25 12C21.25 12.41 20.91 12.75 20.5 12.75L3.67 12.75C3.26 12.75 2.92 12.41 2.92 12C2.92 11.59 3.26 11.25 3.67 11.25Z"
                      fill="#2F415E"/>
            </svg>
            Back to order list</a>
        <div class="order-details-box-main row">
            <div class="order-details__left col-md-6">
                Basic Information
                <basic-info></basic-info>
                Borrower
                <borrower></borrower>
                Contact
                <contact></contact>
                Inspection
                <inspection></inspection>
                Issues
                <issues></issues>
            </div>
            <div class="order-details__right col-md-6">
                Appraisal Details
                <appraisal-details></appraisal-details>
                Client
                <client-info></client-info>
                Call log
                <call-log></call-log>
                Map
                <map-view></map-view>
            </div>
        </div>
        <div class="row">
            <workflow></workflow>
            <history></history>
        </div>
        <div class="mgt-32">
            <files></files>
        </div>

        <div class="note-grid">
            <div class="row">
                <div class="col-md-12">
                    Invoice
                    <invoice></invoice>
                </div>
                <div class="col-md-12">
                    Note
                    <notes></notes>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    Activity log
                    <activity-log></activity-log>
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
