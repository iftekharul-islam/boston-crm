<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Basic Information</p>
      <a href="#" v-b-modal.basic-info class="d-inline-flex edit align-items-center fw-bold">Edit <span
          class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Order no</p>
        <span>:</span>
        <p class="right-side mb-0">{{ orderData.client_order_no }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Due date</p>
        <span>:</span>
        <p class="right-side mb-0">{{ orderData.due_date }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Order receive date</p>
        <span>:</span>
        <p class="right-side mb-0">{{ orderData.received_date }}</p>
      </div>
    </div>
    <b-modal id="basic-info" size="lg" title="Edit Basic Information">
      <div class="modal-body">
        <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
        <div class="row">
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Due date </label>
              <v-date-picker v-model="orderData.due_date">
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
              <label for="" class="d-block mb-2 dashboard-label">Order no</label>
              <input type="text" v-model="orderData.client_order_no" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Order receive date</label>
              <v-date-picker v-model="orderData.received_date">
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
    orderId: String,
    order: [],
  },
  data() {
    return {
      orderData:{
        client_order_no: '',
        due_date: new Date(),
        received_date: new Date(),
      },
      message: ''
    }
  },
  created() {
    this.getBasicInfo();
  },
  methods: {
    getBasicInfo(){
      this.orderData.client_order_no = this.order.client_order_no
      this.orderData.due_date = this.order.due_date
      this.orderData.received_date = this.order.received_date
    },
    updateBasicInfoData(){
      let that = this
      axios.post('update-basic-info/'+ this.orderId,this.orderData)
          .then(res => {
            this.message = res.data.message
            setTimeout(function(){
              that.$bvModal.hide('basic-info')
              that.message = ''
            }, 2000);
          }).catch(err => {
            console.log(err)
      })
    }
  }
}
</script>
