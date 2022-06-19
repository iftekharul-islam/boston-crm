<template>
  <div class="schedule-part">
    <div v-if="alreadyScheduled == 1" class="scheduling-item step-items">
    <a class="edit-btn"><span @click="editSchedule" class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
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
      <p class="text-light-black mgb-12">Duration</p>
      <p class="mb-0 text-light-black fw-bold">{{ scheduleData.duration }}</p>
    </div>
  </div>
    <div v-else class="scheduling-item step-items">
      <p>Not yet scheduled, Click Schedule button to schedule the order</p>
      <div class="text-end mgt-32">
        <button v-if="alreadyScheduled == 0" type="button" v-b-modal.schedule
                class="button button-primary px-4 h-40 d-inline-flex align-items-center">Schedule
        </button>
        
      </div>
    </div>
    <b-modal id="schedule" size="md" title="Schedule">
        <div class="modal-body">
            <b-alert v-if="message" show variant="success">
            <a href="#" class="alert-link">{{ message }}</a></b-alert>
            <div class="row">
                <div class="col-md-12">
                    <ValidationObserver ref="scheduleForm">
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
                                    :key="duration.duration"
                                    :value="duration.duration">
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
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button variant="secondary" @click="$bvModal.hide('schedule')">Close</b-button>
            <b-button variant="primary" @click="saveSchedule">Save</b-button>
        </div>
    </b-modal>
    <button @click="mapOpen = true">map</button>
    <button @click="comList = true">Com list</button>
    <!-- map -->
    <div v-if="mapOpen" class="map-direction vue-modal">
        <div class="content">
            <div class="left bg-white">
                  <div class="starting-point">
                    <!-- assign -->
                    <div class="mgb-32 group">
                        <div >
                            <label for="" class="d-block mb-2 dashboard-label">Assign to </label>
                            <div class="position-relative">
                                <select name="" class="dashboard-input w-100 loan-type-select" >
                                    <option value="">Please Select a user</option>
                                    <option >user.name  </option>
                                </select>
                                <span class="icon-arrow-down bottom-arrow-icon"></span>
                            </div>
                        </div>
                    </div>
                    <!-- starting point -->
                    <div class=" group">
                        <label for="" class="d-block mb-2 dashboard-label">Starting point</label>
                        <input type="text" class="dashboard-input w-100 gray-border">
                    </div>
                  </div>
                <!-- destination -->
                <div class="destination mgt-32">
                    <p class="text-600 mgb-12">Destination</p>
                    <ul class="destination-list">
                        <li class="destination-list-item">
                            <span class="drag-dot">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="2" cy="2" r="2" fill="#7E829B"/>
                                    <circle cx="2" cy="10" r="2" fill="#7E829B"/>
                                    <circle cx="10" cy="2" r="2" fill="#7E829B"/>
                                    <circle cx="10" cy="10" r="2" fill="#7E829B"/>
                                </svg>
                            </span>
                            <input type="text" class="dashboard-input w-100 gray-border">
                            <button class="button button-transparent p-0 del-icon">
                                <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                            </button>
                        </li>
                        <li class="destination-list-item">
                            <span class="drag-dot">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="2" cy="2" r="2" fill="#7E829B"/>
                                    <circle cx="2" cy="10" r="2" fill="#7E829B"/>
                                    <circle cx="10" cy="2" r="2" fill="#7E829B"/>
                                    <circle cx="10" cy="10" r="2" fill="#7E829B"/>
                                </svg>
                            </span>
                            <input type="text" class="dashboard-input w-100 gray-border">
                            <button class="button button-transparent p-0 del-icon">
                                <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                            </button>
                        </li>
                        <li class="destination-list-item">
                            <span class="drag-dot">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="2" cy="2" r="2" fill="#7E829B"/>
                                    <circle cx="2" cy="10" r="2" fill="#7E829B"/>
                                    <circle cx="10" cy="2" r="2" fill="#7E829B"/>
                                    <circle cx="10" cy="10" r="2" fill="#7E829B"/>
                                </svg>
                            </span>
                            <input type="text" class="dashboard-input w-100 gray-border">
                            <button class="button button-transparent p-0 del-icon">
                                <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                            </button>
                        </li>
                    </ul>
                   <div class="text-end">
                     <button class="button button-transparent p-0 primary-text"><span class="icon-plus"></span> Add destination</button>
                   </div>
                    
                </div>
                <!-- time -->
                <div class="destination-time-space">
                    <div class="destination-time d-flex">
                        <div class="left d-flex me-2">
                            <div class="logo mgr-12">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.51 2.83008H8.49C6 2.83008 5.45 4.07008 5.13 5.59008L4 11.0001H20L18.87 5.59008C18.55 4.07008 18 2.83008 15.51 2.83008Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M21.9907 19.82C22.1007 20.99 21.1607 22 19.9607 22H18.0807C17.0007 22 16.8507 21.54 16.6607 20.97L16.4607 20.37C16.1807 19.55 16.0007 19 14.5607 19H9.44071C8.00071 19 7.79071 19.62 7.54071 20.37L7.34071 20.97C7.15071 21.54 7.00071 22 5.92071 22H4.04071C2.84071 22 1.90071 20.99 2.01071 19.82L2.57071 13.73C2.71071 12.23 3.00071 11 5.62071 11H18.3807C21.0007 11 21.2907 12.23 21.4307 13.73L21.9907 19.82Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 8H3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M21 8H20" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <g opacity="0.4">
                                    <path d="M12 3V5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.5 5H13.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <path opacity="0.4" d="M6 15H9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path opacity="0.4" d="M15 15H18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="">
                                <p class="fw-bold mb-0">Via MA-24 N</p>
                                <p class="text-gray fs-14 mb-0">60 min without traffic</p>
                            </div>
                           
                        </div>
                        <div class="right ms-auto">
                             <div class="">
                                <p class="fw-bold mb-0">62 min</p>
                                <p class="text-gray fs-14 mb-0">100 km</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right full-map position-relative">
                <button @click="mapOpen = false" class="button button-transparent x-btn p-0">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 13L13 1" stroke="#2F415E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 13L1 1" stroke="#2F415E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116834.15093170418!2d90.34928581382016!3d23.78062065335469!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1655630336126!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <!-- Com list -->
    <div v-if="comList" class="com-list vue-modal">
        <div class="content w-100 max-w-556">
            <p class="fs-20 fw-bold mgb-20">COM list</p>
            <div class="">
                <p class="mgb-8">Add new</p>
                <input type="text" class="dashboard-input w-100 gray-border">
                <div class="text-end">
                    <span class="add primary-text fw-bold">
                        <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.29515 8.6053C4.05503 8.6053 3.82691 8.50925 3.65883 8.34117L0.261131 4.94347C-0.0870435 4.5953 -0.0870435 4.01901 0.261131 3.67084C0.609305 3.32266 1.18559 3.32266 1.53377 3.67084L4.29515 6.43222L10.4662 0.261131C10.8144 -0.0870435 11.3907 -0.0870435 11.7389 0.261131C12.087 0.609305 12.087 1.18559 11.7389 1.53377L4.93147 8.34117C4.76338 8.50925 4.53527 8.6053 4.29515 8.6053Z" fill="#19B7A2"/>
                        </svg>
                        Add</span>
                </div>
            </div>
            <!-- map name -->
            <div class="map-name mgt-20">
                <div class="map-name-list d-flex justify-content-between">
                    <p class="mb-0">30 Richard Id, Braintree MA 12563, USA</p>
                    <span class="icon-trash fs-20 cursor-pointer"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                </div>
                <div class="map-name-list d-flex justify-content-between">
                    <p class="mb-0">30 Richard Id, Braintree MA 12563, USA</p>
                    <span class="icon-trash fs-20 cursor-pointer"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                </div>
                <div class="map-name-outline mgb-20">
                    <span class="d-inline-block me-2">
                        <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5455 7.10145L14.5453 7.14009C14.5453 7.15636 14.5451 7.17264 14.5449 7.18892C14.5453 7.20792 14.5455 7.22706 14.5455 7.24638C14.5455 10.2793 12.1825 12.964 10.6012 14.7606C10.1424 15.2819 9.74943 15.7284 9.49907 16.087C8.60853 17.3623 8.13853 18.744 8.01484 19.2754C8.01484 19.6756 7.68259 20 7.27273 20C6.86286 20 6.53061 19.6756 6.53061 19.2754C6.40692 18.744 5.93692 17.3623 5.04638 16.087C4.79603 15.7284 4.40303 15.2819 3.94421 14.7606C2.36297 12.964 0 10.2793 0 7.24638C0 7.22706 0.00018118 7.20792 0.000543541 7.18892C0.00018118 7.1598 0 7.13064 0 7.10145C0 3.17942 3.2561 0 7.27273 0C11.2894 0 14.5455 3.17942 14.5455 7.10145ZM7.27273 9.71014C8.83019 9.71014 10.0928 8.47731 10.0928 6.95652C10.0928 5.43574 8.83019 4.2029 7.27273 4.2029C5.71526 4.2029 4.45269 5.43574 4.45269 6.95652C4.45269 8.47731 5.71526 9.71014 7.27273 9.71014Z" fill="#34A851"/>
                        <path d="M13.732 3.83497C12.8415 2.15942 11.2872 0.87425 9.40928 0.311523L5.23242 5.05578C5.74596 4.53038 6.47019 4.20305 7.27271 4.20305C8.83018 4.20305 10.0927 5.43589 10.0927 6.95668C10.0927 7.57708 9.88263 8.14957 9.5281 8.60997L13.732 3.83497Z" fill="#4285F5"/>
                        <path d="M4.02877 14.8569C4.00092 14.8252 3.9728 14.7933 3.94443 14.761C2.90214 13.5768 1.52018 12.0067 0.699219 10.2053L5.04043 5.27441C4.67209 5.73973 4.45291 6.32333 4.45291 6.95697C4.45291 8.47775 5.71549 9.71059 7.27295 9.71059C8.0619 9.71059 8.77517 9.39423 9.287 8.88437L4.02877 14.8569Z" fill="#F9BB0E"/>
                        <path d="M1.7208 2.51465C0.64734 3.75212 0 5.35322 0 7.10198C0 7.13117 0.00018118 7.16033 0.000543541 7.18945C0.00018118 7.20845 0 7.22759 0 7.24691C0 8.28065 0.274506 9.27395 0.698994 10.2054L5.03288 5.28281L1.7208 2.51465Z" fill="#E74335"/>
                        <path d="M9.40918 0.311403C8.7336 0.108979 8.01614 0 7.27261 0C5.04692 0 3.05475 0.976244 1.7207 2.51412L5.03279 5.28225L5.04 5.27407C5.10024 5.19797 5.16447 5.12501 5.2324 5.05552L9.40918 0.311403Z" fill="#1A73E6"/>
                        </svg>
                    </span>
                    <p class="mb-0">www.google.com/maps/@23.8457047, 90.4408129,15z</p>
                    <span class="d-inline-block ms-auto">
                         <span class="icon-edit cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
                    </span>
                </div>
            </div>
            <!-- button -->
            <div class="text-end">
                <button class="button button-transparent" @click="comList = false">Close</button>
                <button class="button button-primary px-5">Save</button>
            </div>
        </div>
    </div>
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
    mapOpen: false,
    comList: false,
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
    alreadyScheduled: 0,
    durations: [
        {'duration':'15 minutes'},
        {'duration':'20 minutes'},
        {'duration':'25 minutes'},
        {'duration':'30 minutes'},
        {'duration':'35 minutes'},
        {'duration':'40 minutes'},
        {'duration':'45 minutes'},
        {'duration':'50 minutes'},
        {'duration':'55 minutes'},
        {'duration':'60 minutes'},
    ],
  }),
  created(){
    this.alreadyScheduled = (JSON.parse(this.order.workflow_status)).scheduling
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
            let value = e.target.value
            this.scheduleData.appraiser_id = value
        }.bind(this));
    },
    saveSchedule(){
        this.$boston.post('update-order-schedule',this.scheduleData)
        .then(res => {
            this.message = res.message;
            this.alreadyScheduled = 1;
            setTimeout(() => {
                this.$refs.scheduleForm.reset();
                this.$bvModal.hide('schedule')
                this.message = '';
            },3000);
        }).bind(this)
    },
    editSchedule(){
        this.$bvModal.show('schedule')
        this.getScheduleData()
    }
  }
}
</script>
