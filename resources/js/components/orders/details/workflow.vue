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
            <div class="item">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Revision</p>
            </div>
          </div>
      <!-- step item -->
          <div class="step-item ">
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
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {}
  }
}
</script>
