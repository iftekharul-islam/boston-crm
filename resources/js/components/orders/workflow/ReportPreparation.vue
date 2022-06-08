<template>
  <div class="report-preparation-item step-items">
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
</template>
<script>
export default {
  name: 'ReportPreparation',
  data: () => ({})
}
</script>
