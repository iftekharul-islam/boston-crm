<template>
    <div>
        <div class="quality-assurance-item step-items">
            <div v-if="currentStep == 'view' || currentStep == 'create'">
                <div class="group">
                    <p class="text-light-black mgb-12">Instruction from previous step</p>
                    <p class="text-success">(Rewrite & send back)</p>
                    <p class="mb-0 text-light-black fw-bold">{{ order.analysis.rewrite_note }}</p>
                </div>
                <div class="group">
                    <p class="text-success">(Check & Upload)</p>
                    <p class="mb-0 text-light-black fw-bold">{{ order.analysis.note }}</p>
                </div>
                <div v-if="currentStep == 'view'">
                    <a class="edit-btn" v-if="qa.note != ''" @click="editQualityAssurance"><span class="icon-edit"><span
                                class="path1"></span><span class="path2"></span></span></a>
                    <div class="group">
                        <p class="text-light-black mgb-12">Instruction from this step</p>
                        <p class="mb-0 text-light-black fw-bold">{{ qa.note }}</p>
                    </div>
                    <div class="group">
                        <p class="text-light-black mgb-12">Assigned to</p>
                        <p class="mb-0 text-light-black fw-bold">{{ qa.assigned_name }}</p>
                    </div>
                    <div class="group">
                        <p class="text-light-black mgb-12">Original effective date</p>
                        <p class="mb-0 text-light-black fw-bold">{{ this.order.due_date }}</p>
                    </div>
                    <div class="group">
                        <p class="text-light-black mgb-12">Changed effective date</p>
                        <p class="mb-0 text-light-black fw-bold">{{ qa.effective_date }}</p>
                    </div>
                </div>
                <div class="group">
                    <p class="text-light-black mgb-12">Files</p>
                    <div class="d-flex align-items-center" v-for="attachment in order.analysis.attachments">
                        <div class="file-img">
                            <img src="/img/pdf.png" alt="boston pdf image">
                        </div>
                        <div class="mgl-12">
                            <p class="text-light-black mb-0">{{ attachment.name }}</p>
                            <p class="text-gray mb-0 fs-12">Uploaded: {{ order.analysis.updated_by.name + ', ' +
                                order.analysis.updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="qa.note == '' || currentStep == 'edit'">
                <div class="group">
                    <p class="text-light-black mgb-12">Files</p>
                    <div class="d-flex align-items-center" v-for="attachment in order.quality_assurance.attachments">
                        <div class="file-img">
                            <img src="/img/pdf.png" alt="boston pdf image">
                        </div>
                        <div class="mgl-12">
                            <p class="text-light-black mb-0">{{ attachment.name }}</p>
                            <p class="text-gray mb-0 fs-12">Uploaded: {{ order.quality_assurance.updated_by.name + ', ' +
                                order.quality_assurance.updated_at }}</p>
                        </div>
                    </div>
                </div>
                <div class="group">
                    <div class="position-relative file-upload">
                        <input type="file" multiple v-on:change="addFiles">
                        <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span
                                    class="path1"></span><span class="path2"></span><span
                                    class="path3"></span></span></label>
                        <p v-if="filesCount > 0">{{ filesCount + 'files selected' }}</p>
                    </div>
                </div>
                <div class="mgb-20">
                    <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                    <div class="preparation-input w-100 position-relative">
                        <textarea v-model="qa.note" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                    </div>
                </div>
                <button class="btn btn-secondary b-1">Add comparable list for original photo</button>
                <div class="text-end mgt-32">
                    <button class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                        @click="updateQualityAssurance">Done</button>
                </div>
            </div>
            <div v-if="currentStep == 'create'">
                <ValidationObserver ref="qualityAssuranceForm">
                    <div class="mgb-32">
                        <ValidationProvider class="group" name="Assigned to" rules="required" v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Assigned to<span
                                        class="text-danger require"></span></label>
                                <select class="dashboard-input w-100" v-model="qa.assigned_to">
                                    <option value="">Please select to assign</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                </ValidationObserver>
                <div class="group">
                    <p class="text-light-black mgb-12">Effective Date</p>
                    <p class="mb-0 text-light-black fw-bold">{{ order.due_date }}</p>
                </div>
                <div class="group">
                    <label for="" class="d-block mb-2 dashboard-label">Modify Effective date</label>
                    <v-date-picker v-model="qa.effective_date"
                        :available-dates='{ start: qa.effective_date, end: null }'>
                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                            <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" />
                        </template>
                    </v-date-picker>
                </div>
                <div class="text-end mgt-32">
                    <button class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                        @click="saveQualityAssurance">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'QualityAssurance',
        props: {
            order: [],
            users: []
        },
        data: () => ({
            qa: {
                qa_id: 0,
                order_id: '',
                effective_date: '',
                assigned_to: '',
                assigned_name: '',
                note: '',
                files: [],
            },
            message: '',
            filesCount: '',
            currentStep: 'create',
            alreadyQualityAssurance: 0,
        }),
        created() {
            this.getReportAnalysisData()
            this.alreadyQualityAssurance = (JSON.parse(this.order.workflow_status)).qualityAssurance
            this.alreadyQualityAssurance == 1 ? this.currentStep = 'view' : 'create'
        },
        methods: {
            getReportAnalysisData() {
                this.qa.order_id = this.order.id
                this.qa.effective_date = this.order.due_date
                if (this.order.quality_assurance) {
                    this.qa.qa_id = this.order.quality_assurance.id
                    this.qa.note = this.order.quality_assurance.note
                    this.qa.assigned_to = this.order.quality_assurance.assigned_to
                    this.qa.assigned_name = this.order.quality_assurance.assignee.name
                    this.qa.effective_date = this.order.quality_assurance.effective_date
                }
            },
            saveQualityAssurance() {
                this.$refs.qualityAssuranceForm.validate().then((status) => {
                    if (status) {
                        let self = this
                        this.$boston.post('save-quality-assurance', this.qa)
                            .then(res => {
                                this.message = res.message
                                setTimeout(() => {
                                    self.$refs.qualityAssuranceForm.reset();
                                    self.message = '';
                                }, 3000);
                            }).catch(err => {
                                console.log(err)
                            })
                    }
                })
            },
            addFiles(event) {
                this.qa.files = event.target.files
                this.filesCount = event.target.files.length
            },
            editQualityAssurance() {
                this.currentStep = 'edit'
                console.log(this.currentStep)
            },
            updateQualityAssurance() {
                let formData = new FormData();
                for (let i = 0; i < this.qa.files.length; i++) {
                    let file = this.qa.files[i];
                    formData.append('files[' + i + ']', file);
                }
                formData.append('note', this.qa.note)
                formData.append('qa_id', this.qa.qa_id)
                this.$boston.post('update-quality-assurance', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    this.message = res.message
                }).catch(err => {
                    console.log(err)
                })

            }
        }
    }
</script>
