<template>
  <div class="order-details__left col-md-8">
    <!-- Workflow -->
    <div class="order-details-box bg-white h-100">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Workflow</p>
        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span
            class="path1"></span><span class="path2"></span></span></a>
      </div>
      <div class="box-body">
        <div class="workflow-content">
<!--          step list-->
          <div class="list">
            <div class="item complete">
                <span class="ball">
                    <img src="/img/current-white.png" alt="current step boston">
                </span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item complete">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Scheduling</p>
            </div>
             <div class="item current">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Inspection</p>
            </div>
            <div class="item">
                <span class="ball">
                    <img src="/img/current-white.png" alt="current step boston">
                </span>
              <p class="mb-0">Report Preparation</p>
            </div>
            <div class="item">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Initial Review</p>
            </div>
            <div class="item">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Report Analysis and Review</p>
            </div>
            <div class="item">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Re-writing the report</p>
            </div>
             <div class="item">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Quality Assurance (E&O)</p>
            </div>
             <div class="item">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Submission</p>
            </div>
            <div class="item" @click="revission()">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Revision</p>
            </div>
          </div>
      <!-- step item -->
          <div class="step-item " >
            <!-- Order creation -->
            <div class="order-creation-item step-items d-none">
              <div class="group">
                <p class="text-light-black mgb-12">Created by</p>
                <p class="mb-0 text-light-black fw-bold">Sadiqur Rahman</p>
              </div>
              <div class="group">
                <p class="text-light-black mgb-12">Create time & date</p>
                <p class="mb-0 text-light-black fw-bold">25 Jan 2022, 3:25 pm</p>
              </div>
              <div class="group">
                <p class="text-light-black mgb-12">Received Date</p>
                <p class="mb-0 text-light-black fw-bold">26 Jan 2022</p>
              </div>
              <div class="group">
                <p class="text-light-black mgb-12">Due date</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
            </div>
            <!-- Scheduling -->
            <div class="scheduling-item step-items d-none">
              <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Scheduled by</p>
                <p class="mb-0 text-light-black fw-bold">Sadiqur Rahman</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Schedule Date and Time</p>
                  <p class="mb-0 text-light-black fw-bold">25 Jan 2022</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Instruction or Note for Inspection</p>
                  <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                    in laying out print, graphic or web designs. The passage is attributed
                    to an unknown</p>
              </div>
                <div class="group">
                  <p class="text-light-black mgb-12">Schedule Date and Time</p>
                  <p class="mb-0 text-light-black fw-bold">25 Jan 2022</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Durration</p>
                  <p class="mb-0 text-light-black fw-bold">4 hours</p>
              </div>
              <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Schedule</button>
              </div>
            </div>
            <!-- Inspection -->
            <div class="inspection-item step-items d-none">
               <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
                  <div class="group">
                    <p class="text-light-black mgb-12">Appraiser II</p>
                    <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
                </div>
                <div class="group">
                  <p class="text-light-black mgb-12">Instruction or Note for Inspection</p>
                  <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                    in laying out print, graphic or web designs. The passage is attributed
                    to an unknown</p>
              </div>
                <div class="group">
                  <p class="text-light-black mgb-12">Inspection file upload</p>
                  <div class="d-flex align-items-center">
                    <div class="file-img">
                      <img src="/img/pdf.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                      <p class="text-light-black mb-0">Inspection details</p>
                      <p class="text-gray mb-0 fs-12">Uploaded: Sadik Raihan, 25 Jun 22, 3:45pm</p>
                    </div>
                  </div>
                  <!-- upload -->
                   <div class="position-relative file-upload mgt-20">
                    <input type="file">
                    <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                  </div>
              </div>
               <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Save</button>
              </div>
            </div>
            <!-- Report preparation -->
            <div class="report-preparation-item step-items d-none">
                <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Report creator</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Report reviewer</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Traineee</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Note</p>
                  <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                    in laying out print, graphic or web designs. The passage is attributed
                    to an unknown</p>
              </div>
               <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Trainee selection</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                 <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                  <div class="preparation-input w-100 position-relative">
                    <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                  </div>
                </div>
                <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Files</label>
                   <!-- upload -->
                   <div class="position-relative file-upload mgt-20">
                    <input type="file">
                    <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                  </div>
                </div>
                <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
              </div>

            </div>
            <!-- Initial Review -->
            <div class="initial-review-item step-items d-none">
                <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Report creator</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Report reviewer</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Traineee</p>
                <p class="mb-0 text-light-black fw-bold">15 Feb 2022</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Note</p>
                  <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                    in laying out print, graphic or web designs. The passage is attributed
                    to an unknown</p>
              </div>
               <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Trainee selection</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                 <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                  <div class="preparation-input w-100 position-relative">
                    <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                  </div>
                  <div class="checkbox-group review-check mgt-20">
                    <input type="checkbox" class="checkbox-input check-data"> 
                    <label for="" class="checkbox-label text-capitalize">Review done</label>
                  </div>
                </div>
                <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
              </div>

            </div>
            <!-- Report Analysis and Review -->
            <div class="report-analysis-item step-items d-none">
                <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Note from previous steps</p>
                <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                  in laying out print, graphic or web designs. The passage is attributed
                  to an unknown</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Note from this step</p>
                <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
                <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                in laying out print, graphic or web designs. The passage is attributed
                to an unknown</p>
              </div>
                 <div class="group">
                    <p class="text-light-black mgb-12">Note from this step</p>
                    <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
                    <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                    in laying out print, graphic or web designs. The passage is attributed
                    to an unknown</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Assign to</p>
                <p class="mb-0 text-light-black fw-bold">Hafizur Rahman</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Inspection file upload</p>
                  <div class="d-flex align-items-center">
                    <div class="file-img">
                      <img src="/img/pdf.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                      <p class="text-light-black mb-0">Inspection details</p>
                      <p class="text-gray mb-0 fs-12">Uploaded: Sadik Raihan, 25 Jun 22, 3:45pm</p>
                    </div>
                  </div>
                
              </div>
               <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                 <div class="mgb-20">
                  <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                  <div class="preparation-input w-100 position-relative">
                    <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                  </div>
                </div>
                <div class="mgb-32 d-flex align-items-center">
                  <div class="checkbox-group review-check mgr-20">
                    <input type="checkbox" class="checkbox-input check-data"> 
                    <label for="" class="checkbox-label text-capitalize">Rewrite & send back</label>
                  </div>
                   <div class="checkbox-group review-check">
                    <input type="checkbox" class="checkbox-input check-data"> 
                    <label for="" class="checkbox-label text-capitalize">Check & upload</label>
                  </div>
                </div>
                  <!-- upload -->
                   <div>
                     <label for="" class="mb-2 text-light-black d-inline-block">Files</label>
                      <div class="position-relative file-upload">
                        <input type="file">
                        <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                      </div>
                   </div>
                <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
              </div>

            </div>
            <!-- Re-writing the report -->
            <div class="re-writing-report-item step-items d-none">
                <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Note from previous stpes</p>
                <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                  in laying out print, graphic or web designs. The passage is attributed
                  to an unknown</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Note from this step</p>
                <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
                <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                in laying out print, graphic or web designs. The passage is attributed
                to an unknown</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Assign to</p>
                <p class="mb-0 text-light-black fw-bold">Hafizur Rahman</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Inspection file upload</p>
                  <div class="d-flex justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="file-img">
                          <img src="/img/pdf.png" alt="boston pdf image">
                        </div>
                        <div class="mgl-12">
                          <p class="text-light-black mb-0">Inspection details</p>
                          <p class="text-gray mb-0 fs-12">Uploaded: Sadik Raihan, 25 Jun 22, 3:45pm</p>
                        </div>
                      </div>
                      <div class="position-relative file-upload">
                        <input type="file">
                        <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                      </div>
                  </div>
                  
              </div>

               <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                 <div class="mgb-20">
                  <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                  <div class="preparation-input w-100 position-relative">
                    <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                  </div>
                </div>
                <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
              </div>

            </div>
             <!-- Quality Assurance (E&O) -->
            <div class="quality-assurance-item step-items d-none">
                <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Note from previous stpes</p>
                <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                  in laying out print, graphic or web designs. The passage is attributed
                  to an unknown</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Note from this step</p>
                <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
                <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                in laying out print, graphic or web designs. The passage is attributed
                to an unknown</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Assign to</p>
                <p class="mb-0 text-light-black fw-bold">Hafizur Rahman</p>
              </div>
               <div class="group">
                  <p class="text-light-black mgb-12">Inspection file upload</p>
                  <div class="d-flex justify-content-between">
                      <div class="d-flex align-items-center">
                        <div class="file-img">
                          <img src="/img/pdf.png" alt="boston pdf image">
                        </div>
                        <div class="mgl-12">
                          <p class="text-light-black mb-0">Inspection details</p>
                          <p class="text-gray mb-0 fs-12">Uploaded: Sadik Raihan, 25 Jun 22, 3:45pm</p>
                        </div>
                      </div>
                      <div class="position-relative file-upload">
                        <input type="file">
                        <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                      </div>
                  </div>
              </div>
              <!-- error -->
              <div class="group">
                  <div class="d-flex align-items-center">
                    <div class="file-img">
                      <img src="/img/error-img.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                      <p class="text-light-black mb-0">Error image</p>
                      <p class="text-gray mb-0 fs-12">Uploaded: Sadik Raihan, 25 Jun 22, 3:45pm</p>
                    </div>
                  </div>
              </div>
                 <div class="mgb-20">
                  <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                  <div class="preparation-input w-100 position-relative">
                    <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                  </div>
                </div>
                <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
              </div>

            </div>
              <!-- Re-writing the report -->
            <div class="re-writing-report-item step-items ">
                <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
               <div class="group">
                <p class="text-light-black mgb-12">Trainee name</p>
                <p class="mb-0 text-light-black fw-bold">Sahabul Gazi</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Quality assureance</p>
                <p class="mb-0 text-light-black fw-bold">Miftahul Robi</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Quality assureance</p>
                <p class="mb-0 text-light-black fw-bold">Hafizur Rahman</p>
              </div>
               <div class="group">
                <p class="text-light-black mgb-12">Delivery date</p>
                <p class="mb-0 text-light-black fw-bold">23 Feb 2022</p>
              </div>
               <div class="group">
                <div class="checkbox-group submission-check mgt-20">
                    <input type="checkbox" class="checkbox-input check-data" checked> 
                    <label for="" class="checkbox-label text-capitalize">Review done</label>
                  </div>
              </div>

               <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                 <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Delivery man</label>
                  <div class="preparation-input w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                 <div class="mgb-20">
                  <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                    <input type="date" class="dashboard-input w-100 position-relative">
                </div>
                <div>
                  <div class="checkbox-group review-check mgt-20">
                    <input type="checkbox" class="checkbox-input check-data"> 
                    <label for="" class="checkbox-label text-capitalize">Chcek it, if trainee signed. </label>
                  </div>
                </div>

                <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
              </div>

            </div>
            

          </div>
          <!-- revission -->
          <div class="revission-modal" v-if="revissionModal">
            <div class="revission-content position-relative">
              <div class="header bg-gray d-flex align-items-center justify-content-between">
                <p class="mb-0 fs-20 fw-bold text-white">Revission</p>
                <span class="cursor-pointer" @click="revission()">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 17L17 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17 17L1 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </span>
              </div>
              <div class="revission-body">
                <!-- add button -->
                <div class="revission-add text-end mb-3">
                  <button v-if="!addRevission" @click="revissionAdd()" class="button button-primary py-2 h-40 flex-center d-inline-flex">Add revission</button>
                </div>
                <!-- add revission form -->
                <div v-if="addRevission" class="add-revission bg-white mgb-12">
                  <p>Add revission</p>
                  <div class="mgb-32 group">
                    <p>Date & time</p>
                    <div class="position-relative">
                      <input type="date" class="dashboard-input w-100 gray-border" >
                      <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                          class="path3"></span><span class="path4"></span><span class="path5"></span><span
                          class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                    </div>
                  </div>
                  <div>
                    <p>Revission details</p>
                    <textarea name="" id="" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
                  </div>
                  <div class="text-end">
                    <button  @click="revissionAdd()" class="button button-transparent px-5 h-40 flex-center">Close</button>
                    <button class="button button-primary px-5 h-40 flex-center d-inline-flex">Add</button>
                  </div>
                </div>
                <!-- revission card -->
                <div class="revission-card bg-white position-relative">
                    <div class="revission-card-top">
                      <div class="revission-card-header d-flex">
                        <div class="revission-name me-3">
                          <p class="mb-0 fs-20 fw-bold">Khadimul islam</p>
                          <p class="mb-0">Today, 3:45 pm</p>
                        </div>
                        <div class="marked">
                          <a href="" class="open fs-14">Open</a>
                          <a href="" class="mark-delivery fs-14">Mark as delivered</a>
                        </div>
                        <div class="button-box ms-auto">
                          <button class="action-btn mgr-12"> <span class="icon-trash"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></button>
                          <button @click="editRevission()" class="action-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></button>
                        </div>
                      </div>
                      <p class="mgb-12">Revission details</p>
                      <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                        in laying out print, graphic or web designs.</p>
                  </div>
                  <!-- solution -->
                  <div class="solution">
                    <div class="solution-header d-flex align-items-start mb-2">
                      <div>
                        <p class="mgb-12">Solution</p>
                        <p class="mb-0">Today, 3:45 pm</p>
                      </div>
                      <div class="button-box ms-auto">
                          <button class="action-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></button>
                      </div>
                    </div>
                    <p class="fw-bold mgb-20">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed
                      to an unknown</p>
                      <div class="d-flex">
                        <div class="col-6">
                          <p class="mgb-10">Delivered by</p>
                          <p class="fw-bold">Khadimul islam</p>
                        </div>
                        <div class="col-6">
                          <p class="mgb-10">Delivered by</p>
                          <p class="fw-bold">Khadimul islam</p>
                        </div>
                      </div>
                  </div>
                  <!-- add solution button -->
                  <div v-if="!addSolution" class="text-end mgt-28">
                    <button @click="solutionAdd()" class="button button-transparent primary-text p-0"> <span class="icon-plus primary-text"></span> <span class="ms-2 primary-text">Add solution</span></button>
                  </div>
                  <!-- add solution box -->
                  <div v-if="addSolution" class="add-solution-box mgt-28">
                    <p class="mgb-8">Add solution</p>
                    <textarea name="" id="" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
                    <div class="d-flex justify-content-end mgt-12">
                      <button @click="solutionAdd()" class="close-solution bg-white fs-14"> <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 9L9 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 9L1 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Close</button>
                      <button class="add-solution bg-white fs-14"><svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.29515 8.6053C4.05503 8.6053 3.82691 8.50925 3.65883 8.34117L0.261131 4.94347C-0.0870435 4.5953 -0.0870435 4.01901 0.261131 3.67084C0.609305 3.32266 1.18559 3.32266 1.53377 3.67084L4.29515 6.43222L10.4662 0.261131C10.8144 -0.0870435 11.3907 -0.0870435 11.7389 0.261131C12.087 0.609305 12.087 1.18559 11.7389 1.53377L4.93147 8.34117C4.76338 8.50925 4.53527 8.6053 4.29515 8.6053Z" fill="#19B7A2"/>
                        </svg>
                        Add</button>
                    </div>
                  </div>
                  <!-- edit revission -->
                      <div v-if="revissionEdit" class="edit-revission">
                        <p class="mgb-22 fs-20 fw-bold">Mark as delivered</p>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Completed by <span class="require"></span> </label>
                            <div class="position-relative">
                                <select name="" id="" class="dashboard-input gray-border w-100">
                                    <option value="">Select one</option>
                                    <option value="">Loan</option>
                                    <option value="">Loan</option>
                                </select>
                                <span class="icon-arrow-down bottom-arrow-icon"></span>
                            </div>
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Delivered by <span class="require"></span> </label>
                            <div class="position-relative">
                                <select name="" id="" class="dashboard-input gray-border w-100">
                                    <option value="">Select one</option>
                                    <option value="">Loan</option>
                                    <option value="">Loan</option>
                                </select>
                                <span class="icon-arrow-down bottom-arrow-icon"></span>
                            </div>
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Delivered by <span class="require"></span> </label>
                            <div class="position-relative">
                              <input type="date" class="dashboard-input w-100 gray-border" >
                              <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                                  class="path3"></span><span class="path4"></span><span class="path5"></span><span
                                  class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                            </div>
                        </div>
                        <div class="group">
                            <label for="" class="mb-2 text-light-black d-inline-block">Add solution <span class="require"></span></label>
                            <div class="preparation-input w-100 position-relative">
                              <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <button @click="editRevission()" class="button button-transparent px-5 h-40 flex-center">Close</button>
                            <button class="button button-primary px-5 h-40 flex-center d-inline-flex">Mark</button>
                          </div>
                      </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      revissionModal: false,
      addRevission: false,
      addSolution: false,
      revissionEdit: false
    }
  },
  methods: {
    revission() {
      this.revissionModal = !this.revissionModal
    },
    revissionAdd() {
      this.addRevission = !this.addRevission;
    },
    solutionAdd() {
      this.addSolution = !this.addSolution
    },
    editRevission() {
      this.revissionEdit = !this.revissionEdit
    }
  },
}
</script>
