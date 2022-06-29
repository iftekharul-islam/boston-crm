<template>
    <b-modal id="re-schedule" size="md" title="Schedule">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <ValidationObserver ref="scheduleForm">
                        <ValidationProvider class="group d-block" name="Appraiser name" rules="required"
                            v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Appraiser name<span
                                        class="text-danger require"></span></label>
                                <m-select :options="appraisers" object item-value="id" item-text="name"
                                    v-model="schedule.appraiser_id"></m-select>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="d-block dashboard-label group" name="Inspection date & time"
                            rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Inspection date & time<span
                                        class="text-danger require"></span></label>
                                <v-date-picker mode="datetime" v-model="schedule.inspection_date_time"
                                    :available-dates='{ start: new Date(), end: null }'>
                                    <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                        <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" />
                                    </template>
                                </v-date-picker>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="group d-block" name="Duration" rules="required" v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Duration <span
                                        class="text-danger require"></span></label>
                                <m-select :options="durations" object item-text="duration" item-value="duration"
                                    v-model="schedule.duration"></m-select>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="d-block dashboard-label group" name="Notes" rules="required"
                            v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Notes <span
                                        class="text-danger require"></span></label>
                                <b-form-textarea class="dashboard-textarea" v-model="schedule.note"
                                    placeholder="Enter notes..." rows="2" cols="5">
                                </b-form-textarea>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="d-block dashboard-label group" name="Cause of reschedule" rules="required"
                            v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Cause of Reschedule <span
                                        class="text-danger require"></span></label>
                                <b-form-textarea class="dashboard-textarea" v-model="schedule.reschedule_note"
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
            <b-button v-if="isInspected == 0" variant="danger" @click="deleteSchedule">Delete Icon</b-button>
            <b-button variant="secondary" @click="$bvModal.hide('re-schedule')">Close</b-button>
            <b-button variant="primary" @click="reSchedule">Save</b-button>
        </div>
    </b-modal>
</template>
<script>
    import Calendar from 'v-calendar/lib/components/calendar.umd'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'

    Vue.component('VCalendar', Calendar)
    Vue.component('VDatePicker', DatePicker)
    export default {
        name: 'Schedule',
        props: {
            appraisers: [],
            scheduleData: []
        },
        data: () => ({
            schedule: {
                schedule_id: 0,
                order_id: '',
                appraiser_id: '',
                inspection_date_time: '',
                duration: '',
                note: '',
                reschedule_note: '',
            },
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
            isInspected: 0,
            edited: {}
        }),
        watch: {
            scheduleData(newValue){
                this.scheduleData = newValue.inspection
                this.isInspected = (JSON.parse(newValue.workflow_status)).inspection
                this.getScheduleData(this.scheduleData)
            },
        },
        methods: {
            getScheduleData(scheduleData) {
                this.schedule.order_id = scheduleData.order_id
                this.schedule.schedule_id = scheduleData.id
                this.schedule.appraiser_id = scheduleData.inspector_id
                this.schedule.inspection_date_time = scheduleData.inspection_date_time
                this.schedule.duration = scheduleData.duration
                this.schedule.note = scheduleData.note
                this.schedule.reschedule_note = scheduleData.reschedule_note
            },
            reSchedule() {
                this.$refs.scheduleForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('update-order-schedule', this.schedule)
                            .then(res => {
                                this.orderData = res.data;
                                //this.$root.$emit('wk_update', res.data)
                                //this.$root.$emit('wk_flow_menu', res.data)
                                //this.$root.$emit('wk_flow_toast', res)
                                this.$bvModal.hide('re-schedule')
                            })
                    }
                })
            },
            deleteSchedule(){

            }
        }
    }
</script>
