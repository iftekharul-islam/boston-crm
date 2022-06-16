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
            <div class="group">
                <p class="text-light-black mgb-12">Review Done</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.is_review_done == '1' ? 'yes' : 'no' }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Review Done as check & upload</p>
                <p class="mb-0 text-light-black fw-bold">{{ initialReview.is_check_upload == '1' ? 'yes' : 'no' }}</p>
            </div>
            <br /><br />
        </div>
        <div class="initial-review-form" v-if="currentStep == 'create' || currentStep == 'edit'">
            <ValidationObserver ref="initialReviewForm">
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Assigned to" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Assigned to<span
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
                            <label for="" class="d-block mb-2 dashboard-label">Notes <span
                                    class="text-danger require"></span></label>
                            <b-form-textarea v-model="initialReview.note" placeholder="Enter notes..." rows="2"
                                cols="5">
                            </b-form-textarea>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                    <div class="checkbox-group review-check mgt-20">
                        <b-form-checkbox v-model="initialReview.is_review_done" value="1" unchecked-value="0">
                            Review done
                        </b-form-checkbox>
                        <b-form-checkbox v-model="initialReview.is_check_upload" value="1" unchecked-value="0">
                            Review done as check & upload
                        </b-form-checkbox>
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
                initial_review_id: 0,
                report_creator_name: '',
                report_reviewer_name: '',
                report_trainee_name: '',
                report_note: '',
                assigned_to: '',
                assigned_name: '',
                note: '',
                is_review_done: '',
                is_check_upload: '',
                order_id: '',
            },
            message: '',
            alreadyInitialReview: 0,
            currentStep: 'create',
        }),
        created() {
            this.initialReview.order_id = this.order.id
            this.alreadyInitialReview = (JSON.parse(this.order.workflow_status)).initialReview
            this.alreadyInitialReview == 1 ? this.currentStep = 'view' : 'create'
            this.getInitialReviewData();
            console.log(this.currentStep)
        },
        methods: {
            getInitialReviewData() {
                this.initialReview.report_creator_name = this.order.report.creator.name
                this.initialReview.report_reviewer_name = this.order.report.reviewer.name
                this.initialReview.report_trainee_name = this.order.report.trainee.name
                this.initialReview.report_note = this.order.report.note
                this.initialReview.initial_review_id = this.order.initial_review.id
                this.initialReview.note = this.order.initial_review.note
                this.initialReview.assigned_name = this.order.initial_review.assignee.name
                this.initialReview.assigned_to = this.order.initial_review.assigned_to
                this.initialReview.is_review_done = this.order.initial_review.is_review_done
                this.initialReview.is_check_upload = this.order.initial_review.is_check_upload
            },
            saveInitialReview() {
                this.$refs.initialReviewForm.validate().then((status) => {
                    if (status) {
                        let self = this
                        this.$boston.post('save-initial-review', this.initialReview)
                            .then(res => {
                                this.message = res.message
                                setTimeout(() => {
                                    self.$refs.initialReviewForm.reset();
                                    self.message = '';
                                }, 3000);
                            }).catch(err => {
                                console.log(err)
                            })
                    }
                })
            },
            editInitialReview() {
                this.currentStep = 'edit'
                console.log('changed')
            }
        }
    }
</script>
