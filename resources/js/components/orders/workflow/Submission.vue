<template>
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
</template>
<script>
export default {
  name: 'Submission',
  data: () => ({})
}
</script>
