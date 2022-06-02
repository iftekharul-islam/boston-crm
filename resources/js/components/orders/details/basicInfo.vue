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
    <b-modal id="basic-info" size="md" title="Edit Basic Information">
      <div class="modal-body">
        <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
        <div class="row">
          <div class="col-md-12">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Due date </label>
              <v-date-picker
               v-model="orderData.due_date"
               :available-dates='{ start: new Date(), end: null }'>
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
import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'

Vue.component('VCalendar', Calendar)
Vue.component('VDatePicker', DatePicker)
export default {
  props:{
    orderId: String,
    order: [],
  },
  components: {

  },
  data() {
    return {
      orderData:{
        client_order_no: '',
        due_date: new Date(),
        received_date: new Date(),
      },
      message: '',
      address: null,
      map: null,
      center: { lat: -25.308, lng: 133.036 },
      currentPlace: null,
      markerIcon: ""
    }
  },
  created() {
    this.getBasicInfo();
  },
  mounted() {

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
    },
  }
}
</script>


<style scoped>

</style>
