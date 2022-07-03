<template>
    <div class="order-details-box bg-white">
        <div class="box-header">
            <p class="fw-bold text-light-black fs-20 mb-0">Inspection</p>
            <a v-if="isScheduled == 1" @click="editInspection"
                class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span
                        class="path1"></span><span class="path2"></span></span></a>
        </div>
        <div v-if="isScheduled == 1" class="box-body">
            <div class="list__group">
                <p class="mb-0 left-side">Appraiser</p>
                <span>:</span>
                <p class="right-side mb-0">{{ inspection.appraiserName }}</p>
            </div>
            <div class="list__group">
                <p class="mb-0 left-side">Inspection date</p>
                <span>:</span>
                <p class="right-side mb-0">{{ inspection.inspection_date_time }}</p>
            </div>
            <div class="list__group">
                <p class="mb-0 left-side">Notes</p>
                <span>:</span>
                <p class="right-side mb-0 line-1">{{ inspection.note }}</p>
            </div>
        </div>
        <div class="text-center mt-3 mb-3" v-else>
            Not yet scheduled !
        </div>
        <b-modal id="inspection" size="md" title="Edit inspection">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="inspectionForm">
                            <ValidationProvider class="group d-block" name="Appraiser name" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                                            class="text-danger require"></span></label>
                                    <m-select v-model="inspection.appraiser_id" :options="appraisers" item-value="id" item-text="name" object></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="d-block group dashboard-label" name="Inspection date & time"
                                rules="required" v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Inspection date & time<span
                                            class="text-danger require"></span></label>
                                    <v-date-picker mode="datetime" v-model="inspection.inspection_date_time"
                                        :available-dates='{ start: new Date(), end: null }'>
                                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                            <input class="dashboard-input w-100" :value="inputValue"
                                                v-on="inputEvents" />
                                        </template>
                                    </v-date-picker>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="group d-block" name="Duration" rules="required" v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Duration <span
                                            class="text-danger require"></span></label>
                                    <!-- <select class="dashboard-input w-100" v-model="inspection.duration">
                                        <option value="">Please select duration</option>
                                        <option v-for="duration in durations" :key="duration.duration"
                                            :value="duration.duration">
                                            {{ duration.duration }}
                                        </option>
                                    </select> -->
                                    <m-select v-model="inspection.duration" :options="durations" item-value="duration" item-text="duration" object></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="d-block group dashboard-label" name="Notes" rules="required"
                                v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Notes <span
                                            class="text-danger require"></span></label>
                                    <b-form-textarea v-model="inspection.note" placeholder="Enter notes..." rows="2"
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
                <b-button variant="secondary" @click="$bvModal.hide('inspection')">Close</b-button>
                <b-button variant="primary" @click="updateInspection">Save</b-button>
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
        props: {
            order: [],
            appraisers: [],
        },
        data: () => ({
            orderData: [],
            isScheduled: 0,
            inspection: {
                order_id: '',
                schedule_id: 0,
                appraiserName: '',
                appraiser_id: '',
                inspection_date_time: '',
                duration: '',
                note: ''
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
            storeData: []
        }),
        created() {
            this.getInspectionData(this.order);
            this.$root.$on('wk_flow_toast', (res) => {
                this.orderData = res.data;
                this.getInspectionData(this.orderData);
            });
        },
        methods: {
            getInspectionData(order) {
                this.orderData = order
                this.isScheduled = (JSON.parse(this.orderData.workflow_status)).scheduling == 1 ? 1 : 0
                if (this.isScheduled == 1) {
                    this.inspection.order_id = this.orderData.id
                    this.inspection.schedule_id = this.orderData.inspection.id
                    this.inspection.appraiserName = this.orderData.inspection.user.name
                    this.inspection.appraiser_id = this.orderData.inspection.inspector_id
                    this.inspection.inspection_date_time = this.orderData.inspection.inspection_date_time
                    this.inspection.note = this.orderData.inspection.note
                    this.inspection.duration = this.orderData.inspection.duration
                }
            },
            editInspection() {
                this.$bvModal.show('inspection')
                this.getInspectionData()
            },
            updateInspection() {
                this.$refs.inspectionForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('update-order-schedule', this.inspection)
                            .then(res => {
                                this.orderData = res.data;
                                this.$root.$emit('wk_update', this.orderData);
                                this.$root.$emit('wk_flow_menu', this.orderData);
                                this.$root.$emit('wk_flow_toast', res);
                                this.$bvModal.hide('inspection')
                            })
                    }
                })
            },
        }
    }
</script>
