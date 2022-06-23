<template>
  <ValidationObserver ref="basicInfo">
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
          <p class="right-side mb-0 word-break">{{ edited.client_order_no }}</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Due date</p>
          <span>:</span>
          <p class="right-side mb-0">{{ edited.due_date }}</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Order receive date</p>
          <span>:</span>
          <p class="right-side mb-0">{{ edited.received_date }}</p>
        </div>
      </div>

      <b-modal id="basic-info" size="md" title="Edit Basic Information">
        <div class="modal-body">
          <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
          <div class="row">
            <div class="col-md-12">
              <div class="group">
                <ValidationProvider class="d-block mb-2 dashboard-label" name="Due date" rules="required"
                                    v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Overdue date <span
                        class="text-danger require"></span></label>
                    <v-date-picker
                        v-model="orderData.due_date"
                        :available-dates='{ start: new Date(), end: null }'  @input="checkDateInput(orderData.due_date, 2)">
                      <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                        <input
                            class="dashboard-input w-100"
                            :value="inputValue"
                            v-on="inputEvents"
                        />
                      </template>
                    </v-date-picker>
                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
              </div>
              <div class="group">
                <ValidationProvider class="d-block mb-2 dashboard-label" name="Client order no" rules="required"
                                    v-slot="{ errors }">
                    <div :class="{ 'invalid-form' : errors[0] || oldOrderNo }">
                    <label for="" class="d-block mb-2 dashboard-label">CLient order no <span
                        class="text-danger require"></span></label>
                    <input type="text" v-model="orderData.client_order_no" class="dashboard-input w-100" @input="checkclientOrderNo($event)">
                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                      <span v-if="oldOrderNo" class="error-message">This client order no. has been taken.</span>
                  </div>
                </ValidationProvider>
              </div>
              <div class="group">
                <ValidationProvider class="d-block mb-2 dashboard-label" name="Order receive date" rules="required"
                                    v-slot="{ errors }">
                    <div :class="{ 'invalid-form' : (errors[0] || dateIssue.status) }">
                    <label for="" class="d-block mb-2 dashboard-label">Received date <span
                        class="text-danger require"></span></label>
                    <v-date-picker v-model="orderData.received_date"  @input="checkDateInput(orderData.received_date, 1)">
                      <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                        <input
                            class="dashboard-input w-100"
                            :value="inputValue"
                            v-on="inputEvents"
                        />
                      </template>
                    </v-date-picker>
                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                    <span v-if="dateIssue.status" class="error-message">{{ dateIssue.message }}</span>
                  </div>
                </ValidationProvider>
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
  </ValidationObserver>
</template>
<script>
import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'

Vue.component('VCalendar', Calendar)
Vue.component('VDatePicker', DatePicker)
export default {
  props: {
    orderId: String,
    order: [],
  },
  components: {},
  data() {
    return {
        oldOrderNo: false,
        dateIssue: {
            status: false,
            message: "Received Date Must Be Smaller Than Due Date"
        },
      orderData: {
        client_order_no: '',
        due_date: new Date(),
        received_date: new Date(),
      },
      edited: {},
      message: '',
      address: null,
      map: null,
      center: {lat: -25.308, lng: 133.036},
      currentPlace: null,
      markerIcon: "",
      errorStatus: false
    }
  },
  created() {
    this.getBasicInfo(this.order);
  },
  methods: {
    checkDateInput(value, type) {
          this.dateIssue.status = false;
          var date = new Date(value);
          if (type == 1) {
              if (this.orderData.due_date) {
                  let dueDate = new Date(this.orderData.due_date);
                  if (dueDate < date) {
                      this.dateIssue.status = true;
                  }
              }
          } else {
              if (this.orderData.received_date) {
                  let receiveDate = new Date(this.orderData.received_date);
                  if (receiveDate > date) {
                      this.dateIssue.status = true;
                  }
              }
          }
      },
    getBasicInfo(order) {
      let orderData = order
      this.orderData.client_order_no = orderData.client_order_no
      this.orderData.due_date = orderData.due_date
      this.orderData.received_date = orderData.received_date
      this.edited = Object.assign({}, this.orderData);
    },
    updateBasicInfoData(){
      let that = this
      axios.post('update-basic-info/'+ this.orderId,this.orderData)
        .then(res => {
          //   this.$root.$emit('wk_update', res.data.data)
          //   this.$root.$emit('wk_flow_menu', res.data.data)
          //   this.$root.$emit('wk_flow_toast', res.data)
          // this.message = res.data.message
          // this.errorStatus = res.data.error;
          if (this.error) {
              this.$root.$emit('wk_flow_toast', res.data)
          } else {
              this.getBasicInfo(res.data.data);
              this.$root.$emit('wk_update', res.data.data)
              this.$root.$emit('wk_flow_menu', res.data.data)
              this.$root.$emit('wk_flow_toast', res.data)
              this.$bvModal.hide('basic-info');
              // setTimeout(function(){
              //   that.$bvModal.hide('basic-info');
              //   that.message = '';
              // }, 5000);
          }
        }).catch(err => {
          console.log(err)
      });
    },
      checkclientOrderNo: _.debounce( function (event) {
          let value = event.target.value;
          this.oldOrderNo = false;
          this.$boston.post('/check/client/order/no', {'client_no' : value}).then((res) => {
              console.log(res);
              this.oldOrderNo = res;
          }).catch(err => {
              console.log(err);
          });
      }, 300),
  }
}
</script>
