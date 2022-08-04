<template>
    <div class="schedule-part">
        <div v-if="alreadyScheduled == 1" class="scheduling-item step-items">
            <a class="edit-btn"><span @click="editSchedule" class="icon-edit"><span class="path1"></span><span
                        class="path2"></span></span></a>
            <div class="group">
                <p class="text-light-black mgb-12">Schedule By</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.created_by }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Schedule Date</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.created_at }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Instruction or Note for Inspection</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.note }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Appraiser</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.inspector_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Inspection Date and Time</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.inspection_date_time_formatted }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Duration</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.duration }}</p>
            </div>
            <div class="group" v-if="orderStatus == 2">
                <p class="text-light-black mgb-12">Reschedule note</p>
                <p class="mb-0 text-light-black fw-bold">{{ edited.reschedule_note }}</p>
            </div>
        </div>
        <div v-else class="scheduling-item step-items no-schedule">
            <div class="text-end mgt-32">
                <button v-if="alreadyScheduled == 0" type="button" v-b-modal.schedule
                    class="button button-primary px-4 h-40 d-inline-flex align-items-center">Schedule
                </button>
            </div>
            <p class="fs-20 fw-bold">Not yet scheduled, Click Schedule button to schedule the order</p>

        </div>
        <b-modal id="schedule" size="md" title="Schedule">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="scheduleForm">
                            <ValidationProvider class="group d-block" name="Appraiser name" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                                            class="text-danger require"></span></label>
                                    <!-- <div class="position-relative">
                                        <select id="apprClientSelect" class="dashboard-input w-100"
                                            v-model="scheduleData.appraiser_id">
                                            <option value="">Please select appraiser</option>
                                            <option v-for="appraisar in appraisers" :key="appraisar.id"
                                                :value="appraisar.id">
                                                {{ appraisar.name }}
                                            </option>
                                        </select>
                                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                                    </div> -->
                                    <m-select :options="appraisers" object item-value="id" item-text="name"
                                        v-model="scheduleData.appraiser_id"></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="d-block dashboard-label group" name="Inspection date & time"
                                rules="required" v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Inspection date & time<span
                                            class="text-danger require"></span></label>
                                    <v-date-picker mode="datetime" v-model="scheduleData.inspection_date_time"
                                        :available-dates='{ start: new Date(), end: null }'>
                                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                            <input class="dashboard-input w-100" :value="inputValue"
                                                v-on="inputEvents" />
                                        </template>
                                    </v-date-picker>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="group d-block" name="Duration" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Duration <span
                                            class="text-danger require"></span></label>
                                    <!-- <div class="position-relative">
                                        <select class="dashboard-input w-100" v-model="scheduleData.duration">
                                            <option value="">Please select duration</option>
                                            <option v-for="duration in durations" :key="duration.duration"
                                                :value="duration.duration">
                                                {{ duration.duration }}
                                            </option>
                                        </select>
                                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                                    </div> -->
                                    <m-select :options="durations" object item-text="duration" item-value="duration"
                                        v-model="scheduleData.duration"></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="d-block dashboard-label group" name="Notes" rules="required"
                                v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Notes <span
                                            class="text-danger require"></span></label>
                                    <b-form-textarea class="dashboard-textarea" v-model="scheduleData.note"
                                        placeholder="Enter notes..." rows="2" cols="5">
                                    </b-form-textarea>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider v-if="alreadyScheduled == 1" class="d-block dashboard-label group"
                                name="Reschedule note" rules="required" v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Reschedule note <span
                                            class="text-danger require"></span></label>
                                    <b-form-textarea class="dashboard-textarea" v-model="scheduleData.reschedule_note"
                                        placeholder="Enter re schedule notes..." rows="2" cols="5">
                                    </b-form-textarea>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button v-if="orderStatus == 1 || orderStatus == 2" class="button button-transparent p-0"
                    @click="showDeleteSchedule">
                    <span class="icon-trash"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span><span class="path4"></span></span>
                </b-button>
                <b-button variant="secondary" @click="$bvModal.hide('schedule')">Close</b-button>
                <b-button variant="primary" @click="saveSchedule">Save</b-button>
            </div>
        </b-modal>
        <b-modal id="delete-schedule" size="md" title="Delete Schedule">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="deleteScheduleForm">
                            <ValidationProvider class="d-block dashboard-label group" name="Cause of deletion"
                                rules="required" v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Cause of Deletion <span
                                            class="text-danger require"></span></label>
                                    <b-form-textarea class="dashboard-textarea" v-model="scheduleData.delete_note"
                                        placeholder="Enter notes..." rows="2" cols="5">
                                    </b-form-textarea>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button variant="secondary" @click="$bvModal.hide('delete-schedule')">Close</b-button>
                <b-button variant="primary" @click="deleteSchedule">Delete</b-button>
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
        name: 'Schedule',
        props: {
            order: [],
            appraisers: [],
        },
        data: () => ({
            orderData: [],
            scheduleData: {
                schedule_id: 0,
                order_id: '',
                appraiser_id: '',
                inspector_name: '',
                inspection_date_time: '',
                inspection_date_time_formatted: '',
                duration: '',
                note: '',
                reschedule_note: '',
                delete_note: '',
                created_by: '',
                created_at: ''
            },
            alreadyScheduled: 0,
            orderStatus: 0,
            durations: [
                { 'duration': '15 minutes' },
                { 'duration': '20 minutes' },
                { 'duration': '25 minutes' },
                { 'duration': '30 minutes' },
                { 'duration': '35 minutes' },
                { 'duration': '40 minutes' },
                { 'duration': '45 minutes' },
                { 'duration': '50 minutes' },
                { 'duration': '55 minutes' },
                { 'duration': '60 minutes' },
            ],
            edited: {}
        }),
        created() {
            let order = this.order;
            //let localOrderData = this.$store.getters['app/orderDetails']
            //if(localOrderData){
            //    order = localOrderData;
            //}
            this.getScheduleData(order)
            //console.log(order)
        },
        methods: {
            getScheduleData(order) {
                this.alreadyScheduled = (JSON.parse(order.workflow_status)).scheduling
                this.scheduleData.order_id = order.id
                this.orderStatus = order.status

                if (this.alreadyScheduled == 1) {
                    this.orderData = order
                    let data = this.orderData.inspection
                    this.scheduleData.schedule_id = data.id
                    this.scheduleData.appraiser_id = data.inspector_id
                    this.scheduleData.inspector_name = data.user.name
                    this.scheduleData.inspection_date_time = new Date(data.inspection_date_time)
                    this.scheduleData.inspection_date_time_formatted = data.inspection_date_time_formatted
                    this.scheduleData.duration = data.duration
                    this.scheduleData.note = data.note
                    this.scheduleData.reschedule_note = data.reschedule_note
                    this.scheduleData.created_at = data.created_at
                    this.scheduleData.created_by = data.create_by.name
                    this.edited = Object.assign({}, this.scheduleData)
                }
            },
            resetScheduleData(){
                this.scheduleData.schedule_id = 0
                this.scheduleData.appraiser_id = ''
                this.scheduleData.reschedule_note = ''
                this.scheduleData.inspection_date_time = ''
                this.scheduleData.duration = ''
                this.scheduleData.note = ''
            },
            select2Features() {
                $(document).on("change", "#apprClientSelect", function (e) {
                    let value = e.target.value
                    this.scheduleData.appraiser_id = value
                }.bind(this));
            },
            saveSchedule() {
                this.$refs.scheduleForm.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        formData.append('order_id', this.scheduleData.order_id)
                        formData.append('schedule_id', this.scheduleData.schedule_id)
                        formData.append('appraiser_id', this.scheduleData.appraiser_id)
                        formData.append('inspection_date_time', this.scheduleData.inspection_date_time)
                        formData.append('duration', this.scheduleData.duration)
                        formData.append('note', this.scheduleData.note)
                        if(this.scheduleData.reschedule_note != ''){
                            formData.append('reschedule_note',this.scheduleData.reschedule_note)
                        }

                        this.$boston.post('update-order-schedule', formData)
                            .then(res => {
                                this.orderData = res.data
                                this.alreadyScheduled = 1
                                this.$root.$emit('wk_update', res.data)
                                this.$root.$emit('wk_flow_menu', res.data)
                                this.$root.$emit('wk_flow_toast', res)
                                this.getScheduleData(res.data)
                                this.$bvModal.hide('schedule')
                            })
                    }
                })
            },
            editSchedule() {
                this.$bvModal.show('schedule')
                this.getScheduleData(this.order)
            },
            showDeleteSchedule() {
                this.$bvModal.show('delete-schedule')
                this.scheduleData.delete_note = ''
            },
            deleteSchedule() {
                this.$refs.deleteScheduleForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('delete-schedule/' + this.scheduleData.schedule_id, { delete_note: this.scheduleData.delete_note })
                            .then(res => {
                                this.orderData = res.data;
                                this.$root.$emit('wk_update', res.data)
                                this.$root.$emit('wk_flow_menu', res.data)
                                this.$root.$emit('wk_flow_toast', res)
                                this.resetScheduleData()
                                this.getScheduleData(res.data)
                                this.$bvModal.hide('delete-schedule')
                                this.$bvModal.hide('schedule')
                            })
                    }
                })
            }
        }
    }
</script>
