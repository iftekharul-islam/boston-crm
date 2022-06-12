<template>
  <div class="inspection-item step-items">
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
</template>
<script>
export default {
  name: 'Inspection',
  data: () => ({})
}
</script>
