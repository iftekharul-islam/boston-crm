<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Appraisal Details</p>
      <a v-b-modal.appaisal-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
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
    <!-- modal -->
     <b-modal id="appaisal-info" size="lg" title="Edit Basic Information">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Search Address <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Street Name <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">City Name <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">State Name <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Zip <span class="require"></span></label>
                <input type="text" class="dashboard-input w-100">
              </div>
            </div>
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Email <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Email <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Email <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Email <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Email <span class="require"></span></label>
                <input type="email" name="email" id="email" class="dashboard-input w-100">
              </div>
            </div>
          </div>
        </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('appaisal-info')">Close</b-button>
        <b-button variant="primary">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
  export default {
    data(){
      return{

      }
    }
  }
</script>
