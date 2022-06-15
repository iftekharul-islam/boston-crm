<template>
  <div class="initial-review-item step-items">
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
      <p class="text-light-black mgb-12">Trainee</p>
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
      <div class="checkbox-group review-check mgt-20">
        <input type="checkbox" class="checkbox-input check-data">
        <label for="" class="checkbox-label text-capitalize">Review done as check & upload</label>
      </div>
    </div>
    <div class="text-end mgt-32">
      <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Done</button>
    </div>
  </div>
</template>
<script>
export default {
  name: 'InitialReview',
  data: () => ({
    initialReview:{
      report_creator_name: '',
      report_reviewer_name: '',
      assigned_to:'',
      trainee_id:'',
      note: '',
      is_review_done:''
    }
  })
}
</script>
