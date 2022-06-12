<template>
  <div class="report-analysis-item step-items">
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
</template>
<script>
export default {
  name: 'ReportAnalysisReview',
  data: () => ({})
}
</script>
