<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Basic Information</p>
      <a href="#" v-b-modal.basic-info class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Property address  </p>
        <span>:</span>
        <p class="right-side mb-0 primary-text fw-bold fs-20">1453 Dorchester Ave, Boston, Ma 02122</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Due date</p>
        <span>:</span>
        <p class="right-side mb-0">25 Jun 2022</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Order no</p>
        <span>:</span>
        <p class="right-side mb-0">25 Jun 2022</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Order receive date</p>
        <span>:</span>
        <p class="right-side mb-0">25 Jun 2022</p>
      </div>
    </div>
    <b-modal id="basic-info" size="lg" title="Edit Basic Information">
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
        <b-button variant="secondary">Close</b-button>
        <b-button variant="primary">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
  export default {
    data(){
      return{
        showModal: false
      }
    }
  }
</script>
