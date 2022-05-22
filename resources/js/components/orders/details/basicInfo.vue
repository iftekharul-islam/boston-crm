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
        <p class="right-side mb-0 primary-text fw-bold fs-20">{{ info.search_address }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Due date</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.due_date }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Order no</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.client_order_no }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Order receive date</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.received_date }}</p>
      </div>
    </div>
    <b-modal id="basic-info" size="lg" title="Edit Basic Information">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Search Address <span class="require"></span></label>
              <input type="text" v-model="info.search_address" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Street Name <span class="require"></span></label>
              <input type="text" v-model="info.street_name" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">City Name <span class="require"></span></label>
              <input type="text" v-model="info.city_name" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">State Name <span class="require"></span></label>
              <input type="text" v-model="info.state_name" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Zip <span class="require"></span></label>
              <input type="text" v-model="info.zip" class="dashboard-input w-100">
            </div>
          </div>
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Unit # <span class="require"></span></label>
              <input type="text" v-model="info.unit_no" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Country <span class="require"></span></label>
              <input type="text" v-model="info.country" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Due date </label>
              <v-date-picker v-model="info.due_date">
                <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                  <input
                      class="dashboard-input w-100"
                      :value="inputValue"
                      v-on="inputEvents"
                  />
                </template>
              </v-date-picker>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Order No</label>
              <input type="text" v-model="info.client_order_no" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Order Receive Date</label>
              <v-date-picker v-model="info.received_date">
                <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                  <input
                      class="dashboard-input w-100"
                      :value="inputValue"
                      v-on="inputEvents"
                  />
                </template>
              </v-date-picker>
            </div>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('basic-info')">Close</b-button>
        <b-button variant="primary" @click="updateBasicInfoData">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  props:{
    orderId: String
  },
  data() {
    return {
      info:{
        search_address: '',
        street_name: '',
        city_name: '',
        state_name: '',
        zip:'',
        unit_no:'',
        country:'',
        due_date: new Date(),
        client_order_no: '',
        received_date: new Date(),
      }
    }
  },
  created() {
    this.getBasicInfo();
  },
  methods: {
    getBasicInfo(){
      axios.get('get-basic-info/' + this.orderId)
          .then(res => {
            this.info.client_order_no = res.data.appraisalDetails.client_order_no
            this.info.due_date = res.data.appraisalDetails.due_date
            this.info.received_date = res.data.appraisalDetails.received_date

            this.info.search_address = res.data.propertyInfo.search_address
            this.info.street_name = res.data.propertyInfo.street_name
            this.info.city_name = res.data.propertyInfo.city_name
            this.info.state_name = res.data.propertyInfo.state_name
            this.info.zip = res.data.propertyInfo.zip
            this.info.country = res.data.propertyInfo.country
            this.info.unit_no = res.data.propertyInfo.unit_no
          }).catch(err => {
        console.log(err)
      })
    },
    updateBasicInfoData(){
      axios.post('update-basic-info/'+ this.orderId,this.info)
          .then(res => {
            console.log(res)
          }).catch(err => {
            console.log(err)
      })
    }
  }
}
</script>
