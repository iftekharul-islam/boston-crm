<template>
  <div class="scheduling-item step-items">
    <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
    <div class="group">
      <p class="text-light-black mgb-12">Scheduled by</p>
      <p class="mb-0 text-light-black fw-bold">Sadiqur Rahman</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Schedule Date and Time</p>
      <p class="mb-0 text-light-black fw-bold">25 Jan 2022</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Instruction or Note for Inspection</p>
      <p class="mb-0 text-light-black fw-bold">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
        in laying out print, graphic or web designs. The passage is attributed
        to an unknown</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Schedule Date and Time</p>
      <p class="mb-0 text-light-black fw-bold">25 Jan 2022</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Durration</p>
      <p class="mb-0 text-light-black fw-bold">4 hours</p>
    </div>
    <div class="text-end mgt-32">
      <button type="button" v-b-modal.schedule class="button button-primary px-4 h-40 d-inline-flex align-items-center">Schedule</button>
    </div>
  </div>
  <b-modal id="basic-info" size="md" title="Edit Basic Information">
    <div class="modal-body">
      <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
      <div class="row">
        <div class="col-md-12">
          <div class="group">

            <ValidationProvider class="d-block mb-2 dashboard-label" name="Inspection date" rules="required"
                                v-slot="{ errors }">
              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Inspection date <span
                    class="text-danger require"></span></label>
                <v-date-picker
                    v-model="schedule.inspection_date"
                    :available-dates='{ start: new Date(), end: null }'>
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
              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">CLient order no <span
                    class="text-danger require"></span></label>
                <input type="text" v-model="orderData.client_order_no" class="dashboard-input w-100">
                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
              </div>
            </ValidationProvider>
          </div>
          <div class="group">
            <ValidationProvider class="d-block mb-2 dashboard-label" name="Order receive date" rules="required"
                                v-slot="{ errors }">
              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Received date <span
                    class="text-danger require"></span></label>
                <v-date-picker v-model="orderData.received_date">
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
        </div>
      </div>
    </div>
    <div slot="modal-footer">
      <b-button variant="secondary" @click="$bvModal.hide('schedule')">Close</b-button>
      <b-button variant="primary" @click="saveSchedule">Save</b-button>
    </div>
  </b-modal>
</template>
<script>
export default {
  name: 'Schedule',
  props: {
    appraisers: [],
  },
  data: () => ({
    message: '',
    schedule:{
      appraiser_id: '',
      inspection_date: '',
      inspection_time: '',
      duration:'',
      note:''
    }
  }),
  methods:{
    saveSchedule(){

    }
  }
}
</script>
