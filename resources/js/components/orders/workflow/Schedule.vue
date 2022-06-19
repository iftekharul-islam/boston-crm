<template>
    <div class="schedule-part">
        <div v-if="alreadyScheduled == 1" class="scheduling-item step-items">
            <a class="edit-btn"><span @click="editSchedule" class="icon-edit"><span class="path1"></span><span
                        class="path2"></span></span></a>
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
                    <a href="#" class="alert-link">{{ message }}</a>
                </b-alert>
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="scheduleForm">
                            <ValidationProvider class="group" name="Appraiser name" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                                            class="text-danger require"></span></label>
                                    <select id="apprClientSelect" class="dashboard-input w-100"
                                        v-model="scheduleData.appraiser_id">
                                        <option value="">Please select appraiser</option>
                                        <option v-for="appraisar in appraisers" :key="appraisar.id"
                                            :value="appraisar.id">
                                            {{ appraisar.name }}
                                        </option>
                                    </select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="d-block mb-2 dashboard-label" name="Inspection date & time"
                                rules="required" v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                                            class="text-danger require"></span></label>
                                    <select id="apprClientSelect" class="dashboard-input w-100"
                                        v-model="scheduleData.appraiser_id">
                                        <option value="">Please select appraiser</option>
                                        <option v-for="appraisar in appraisers" :key="appraisar.id"
                                            :value="appraisar.id">
                                            {{ appraisar.name }}
                                        </option>
                                    </select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="d-block mb-2 dashboard-label" name="Inspection date & time"
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
                            <ValidationProvider class="group" name="Duration" rules="required" v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Duration <span
                                            class="text-danger require"></span></label>
                                    <select class="dashboard-input w-100" v-model="scheduleData.duration">
                                        <option value="">Please select duration</option>
                                        <option v-for="duration in durations" :key="duration.duration"
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
                                    <b-form-textarea v-model="scheduleData.note" placeholder="Enter notes..." rows="2"
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
            message: '',
            orderData: [],
            scheduleData: {
                schedule_id: 0,
                order_id: '',
                appraiser_id: '',
                inspector_name: '',
                inspection_date_time: '',
                duration: '',
                note: ''
            },
            alreadyScheduled: 0,
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
        }),
        created() {
            this.orderData = this.order
            this.alreadyScheduled = (JSON.parse(this.orderData.workflow_status)).scheduling
            this.getScheduleData()
        },
        mounted() {
            $('select').select2();
            this.select2Features();
            this.scheduleData.order_id = this.orderData.id
        },
        methods: {
            getScheduleData() {
                let data = this.orderData.inspection
                if (data) {
                    this.scheduleData.schedule_id = data.id
                    this.scheduleData.order_id = data.order_id
                    this.scheduleData.appraiser_id = data.inspector_id
                    this.scheduleData.inspector_name = data.user.name
                    this.scheduleData.inspection_date_time = data.inspection_date_time
                    this.scheduleData.duration = data.duration
                    this.scheduleData.note = data.note
                }
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
                        this.$boston.post('update-order-schedule', this.scheduleData)
                            .then(res => {
                                this.message = res.message;
                                this.alreadyScheduled = 1;
                                this.orderData = res.data;
                                this.$root.$emit('wk_update', this.orderData);
                                this.$root.$emit('wk_flow_menu', this.orderData);
                                this.getScheduleData()
                                let self = this;
                                setTimeout(function () {
                                    self.$bvModal.hide('schedule')
                                    self.message = '';
                                }, 2000);
                            })
                    }
                })
            },
            editSchedule() {
                this.$bvModal.show('schedule')
                this.getScheduleData()
            },
        }
    }
</script>
