<template>
  <div class="schedule-part">
    <div class="scheduling-item step-items">
    <a class="edit-btn"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
    <div class="group">
      <p class="text-light-black mgb-12">Scheduled by</p>
      <p class="mb-0 text-light-black fw-bold">{{ scheduleData.inspector_name }}</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Schedule Date and Time</p>
      <p class="mb-0 text-light-black fw-bold">{{ scheduleData.inspection_date_time }}</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Instruction or Note for Inspection</p>
      <p class="mb-0 text-light-black fw-bold">{{ scheduleData.note }}</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Durration</p>
      <p class="mb-0 text-light-black fw-bold">{{ scheduleData.duration }} hours</p>
    </div>
    <div class="text-end mgt-32">
      <button type="button" v-b-modal.schedule class="button button-primary px-4 h-40 d-inline-flex align-items-center">Schedule</button>
    </div>
  </div>
    <b-modal id="schedule" size="md" title="Schedule">
        <div class="modal-body">
            <b-alert v-if="message" show variant="success">
            <a href="#" class="alert-link">{{ message }}</a></b-alert>
            <div class="row">
                <div class="col-md-12">
                    <ValidationProvider class="group" name="Appraiser name" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                                class="text-danger require"></span></label>
                            <select id="apprClientSelect" class="dashboard-input w-100" v-model="scheduleData.appraiser_id">
                                <option value="">Please select appraiser</option>
                                <option
                                    v-for="appraisar in appraisers"
                                    :key="appraisar.id"
                                    :value="appraisar.id">
                                    {{ appraisar.name }}
                                </option>
                            </select>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                    <ValidationProvider class="d-block mb-2 dashboard-label" name="Inspection date & time" rules="required"
                                v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Inspection date & time<span
                                class="text-danger require"></span></label>
                            <v-date-picker
                                mode="datetime"
                                v-model="scheduleData.inspection_date_time"
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
                    <ValidationProvider class="group" name="Duration" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Duration <span
                                class="text-danger require"></span></label>
                            <select class="dashboard-input w-100" v-model="scheduleData.duration">
                                <option value="">Please select duration</option>
                                <option
                                    v-for="duration in durations"
                                    :key="duration.id"
                                    :value="duration.id">
                                    {{ duration.duration }}
                                </option>
                            </select>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                    <ValidationProvider class="d-block mb-2 dashboard-label" name="Notes" rules="required"
                                v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Notes <span
                                class="text-danger require"></span></label>
                            <b-form-textarea
                                v-model="scheduleData.note"
                                placeholder="Enter notes..."
                                rows="2"
                                cols="5">
                            </b-form-textarea>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button variant="secondary" @click="$bvModal.hide('schedule')">Close</b-button>
            <b-button variant="primary" @click="saveSchedule">Save</b-button>
        </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  name: 'Schedule',
  props: {
    order: [],
    appraisers: [],
  },
  data: () => ({
    message: '',
    scheduleData:{
        schedule_id: 0,
        order_id: '',
        appraiser_id: '',
        inspector_name: '',
        inspection_date_time: '',
        duration:'',
        note:''
    },
    durations: [{'id': 1,'duration':'1 hour'},{'id': 2,'duration':'2 hour'},{'id': 3,'duration':'3 hour'}],
  }),
  created(){
    this.getScheduleData()
  },
  mounted() {
    $('select').select2();
    this.select2Features();
    this.scheduleData.order_id = this.order.id
  },
  methods:{
    getScheduleData(){
        let data = this.order.inspection
        this.scheduleData.schedule_id = data.id
        this.scheduleData.order_id = data.order_id
        this.scheduleData.appraiser_id = data.inspector_id
        this.scheduleData.inspector_name = data.user.name
        this.scheduleData.inspection_date_time = data.inspection_date_time
        this.scheduleData.duration = data.duration
        this.scheduleData.note = data.note
    },
    select2Features() {
        $(document).on("change", "#apprClientSelect", function(e){
            let value = e.target.value;
            console.log(e.target.value)
            this.scheduleData.appraiser_id = value;
        }.bind(this));
    },
    saveSchedule(){
        this.$boston.post('update-order-schedule',this.scheduleData)
        .then(res => {
            let that = this
            this.message = res.message;
            setTimeout(() => {
                that.$bvModal.hide('schedule')
                that.message = '';
            },3000);
        })
    },
  }
}
</script>
