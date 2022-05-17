<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Basic Information</p>
      <a href="#" v-b-modal.basic-info class="d-inline-flex edit align-items-center fw-bold">Edit <span
          class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Property address </p>
        <span>:</span>
        <p class="right-side mb-0 text-primary fw-bold fs-20">1453 Dorchester Ave, Boston, Ma 02122</p>
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
              <label for="" class="d-block mb-2 dashboard-label">Unit # <span class="require"></span></label>
              <input type="email" name="email" id="email" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Country <span class="require"></span></label>
              <input type="email" name="email" id="email" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Due date </label>
              <v-date-picker v-model="dueDate">
                <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                  <input
                      class="dashboard-input w-100"
                      :value="inputValue"
                      v-on="inputEvents"
                  />
<!--                  <span class="icon-calendar icon"><span class="path1"></span><span-->
<!--                      class="path2"></span><span class="path3"></span><span class="path4"></span><span-->
<!--                      class="path5"></span><span class="path6"></span><span class="path7"></span><span-->
<!--                      class="path8"></span></span>-->
                </template>
              </v-date-picker>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Order No</label>
              <input type="email" name="email" id="email" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Order Receive Date</label>
              <v-date-picker v-model="receiveDate">
                <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                  <input
                      class="dashboard-input w-100"
                      :value="inputValue"
                      v-on="inputEvents"
                  />
<!--                  <span class="icon-calendar icon"><span class="path1"></span><span-->
<!--                      class="path2"></span><span class="path3"></span><span class="path4"></span><span-->
<!--                      class="path5"></span><span class="path6"></span><span class="path7"></span><span-->
<!--                      class="path8"></span></span>-->
                </template>
              </v-date-picker>
            </div>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('basic-info')">Close</b-button>
        <b-button variant="primary">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  data() {
    return {
      showModal: false,
      dueDate: new Date(),
      receiveDate: new Date(),
    }
  },
  created() {
    axios.get('clients')
  },
  methods: {
    clickCalender(){
      this.showCalender = true
      console.log(this.showCalender)
    },
    getBasicInfoData(){

    }
  }
}
</script>
