<template>
    <div>
        <div class="initial-review-item step-items" v-if="currentStep == 'create'">
            <div class="group">
                <p class="text-light-black mgb-12">Report creator</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.report_creator_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Report reviewer</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.report_reviewer_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Report Preparation Notes</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.report_note }}</p>
            </div>
            <br /><br />
        </div>
        <div class="initial-review-item step-items" v-if="currentStep == 'view'">
            <a class="edit-btn" @click="editInitialReview"><span class="icon-edit"><span class="path1"></span><span
                        class="path2"></span></span></a>
            <div class="group">
                <p class="text-light-black mgb-12">Report creator</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.report_creator_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Report reviewer</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.report_reviewer_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Assigned to</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.assigned_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Notes</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.note }}</p>
            </div>
            <div class="mgb-32 d-flex align-items-center">
                <div class="checkbox-group review-check mgr-20" v-if="initialReview.is_review_done == 1">
                    <input type="radio" checked class="checkbox-input check-data">
                    <label for="" class="checkbox-label text-capitalize">Review Done</label>
                </div>
                <div class="checkbox-group review-check" v-if="initialReview.is_check_upload == 1">
                    <input type="radio" checked class="checkbox-input check-data">
                    <label for="" class="checkbox-label text-capitalize">Review Done As Check & upload</label>
                </div>
            </div>
            <br /><br />
        </div>
        <div class="initial-review-form" v-if="currentStep == 'create' || currentStep == 'edit'">
            <ValidationObserver ref="initialReviewForm">
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Assigned to" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Assign to<span
                                    class="text-danger require"></span></label>
                            <select class="dashboard-input w-100" v-model="initialReview.assigned_to">
                                <option value="">Please select to assign</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
                <div class="mgb-32">
                    <ValidationProvider class="d-block mb-2 dashboard-label" name="Notes" rules="required"
                        v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Add note <span
                                    class="text-danger require"></span></label>
                            <b-form-textarea v-model="initialReview.note" placeholder="Enter notes..." rows="2"
                                cols="5">
                            </b-form-textarea>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                    <div class="mgb-32 d-flex align-items-center">
                        <div class="checkbox-group review-check mgr-20">
                            <input type="radio" class="checkbox-input check-data" v-model="initialReview.checkbox"
                                value="1">
                            <label for="" class="checkbox-label text-capitalize">Review Done</label>
                        </div>
                        <div class="checkbox-group review-check">
                            <input type="radio" class="checkbox-input check-data" v-model="initialReview.checkbox"
                                value="2">
                            <label for="" class="checkbox-label text-capitalize">Review Done As Check & upload</label>
                        </div>
                    </div>
                </div>
            </ValidationObserver>
            <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                    @click="saveInitialReview">Done
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'InitialReview',
        props: {
            order: [],
            users: []
        },
        data: () => ({
            initialReview: {
                orderData: [],
                initial_review_id: 0,
                report_creator_name: '',
                report_reviewer_name: '',
                report_trainee_name: '',
                report_note: '',
                assigned_to: '',
                assigned_name: '',
                note: '',
                checkbox: '',
                is_review_done: '',
                is_check_upload: '',
                order_id: '',
            },
            message: '',
            alreadyInitialReview: 0,
            currentStep: 'create',
        }),
        created() {
            this.getInitialReviewData(this.order);

            this.$root.$on("wk_update", (res) => {
                this.getInitialReviewData(res);
            });
        },
        methods: {
            getInitialReviewData(order) {
                this.orderData = order;
                this.initialReview.order_id = this.orderData.id;

                if (this.orderData.report) {
                    this.alreadyInitialReview = (JSON.parse(this.orderData.workflow_status)).initialReview
                    this.alreadyInitialReview == 1 ? this.currentStep = 'view' : 'create'
    
                    this.initialReview.report_creator_name = this.orderData.report.creator.name
                    this.initialReview.report_reviewer_name = this.orderData.report.reviewer.name
                    this.initialReview.report_trainee_name = this.orderData.report.trainee.name
                    this.initialReview.report_note = this.orderData.report.note
                    if (this.orderData.initial_review) {
                        this.initialReview.initial_review_id = this.orderData.initial_review.id
                        this.initialReview.note = this.orderData.initial_review.note
                        this.initialReview.assigned_name = this.orderData.initial_review.assignee.name
                        this.initialReview.assigned_to = this.orderData.initial_review.assigned_to
                        this.initialReview.is_review_done = this.orderData.initial_review.is_review_done
                        this.initialReview.is_check_upload = this.orderData.initial_review.is_check_upload
                        if(this.orderData.initial_review.is_review_done == 1){
                            this.initialReview.checkbox = '1'
                        }else{
                            this.initialReview.checkbox = '2'
                        }
                    }
                }
            },
            saveInitialReview() {
                this.$refs.initialReviewForm.validate().then((status) => {
                    if (status) {
                        let self = this
                        this.$boston.post('save-initial-review', this.initialReview)
                            .then(res => {
                                this.message = res.message
                                this.orderData = res.data
                                this.$root.$emit('wk_update', this.orderData)
                                this.$root.$emit('wk_flow_menu', this.orderData)
                                this.$root.$emit('wk_flow_toast', res);
                                this.getInitialReviewData(res.data);
                                this.currentStep = 'view'
                                setTimeout(() => {
                                    self.$refs.initialReviewForm.reset();
                                    self.message = '';
                                }, 3000);
                            }).catch(err => {
                            })
                    }
                })
            },
            editInitialReview() {
                this.currentStep = 'edit'
            }
        }
    }
</script>
