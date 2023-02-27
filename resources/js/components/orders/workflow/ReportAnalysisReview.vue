<template>
    <div class="report-analysis-item step-items">
        <div v-if="isDataExists">
            <a class="edit-btn" @click.prevent="isDataExists = false"><span class="icon-edit"><span
                        class="path1"></span><span class="path2"></span></span></a>
            <div class="group">
                <p class="text-light-black mgb-12">Note from previous steps</p>
                <p class="mb-0 text-light-black fw-bold" v-if="this.preNote.length" v-html="this.preNote"></p>
                <p class="mb-0 text-light-black fw-bold" v-else>Note not updated yet</p>
            </div>
            <div class="group" v-if="noteCheck == 1">
                <p class="text-light-black mgb-12">Note from this step</p>
                <p href="#" class="primary-text mb-2">(Rewrite & send back)</p>
                <p class="mb-0 text-light-black fw-bold notes-prev" v-html="note"></p>
            </div>
            <div class="group" v-if="noteCheck == 2">
                <p class="text-light-black mgb-12">Note from this step</p>
                <p href="#" class="primary-text mb-2">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold notes-prev" v-html="note"></p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Assign to</p>
                <p class="mb-0 text-light-black fw-bold">{{ assignToName }}</p>
            </div>
            <div class="group" v-if="orderData.analysis.attachments.length">
                <p class="text-light-black mgb-12">Report analysis file</p>
                <div class="document">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3" v-for="(file, key) in orderData.analysis.attachments" :key="key">
                            <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12 file-name">
                                <a :href="file.original_url" download>{{ file.name }}</a>
                                <p class="text-gray mb-0 fs-12">Uploaded: {{ orderData.analysis.updated_by.name
                                    + ', ' +
                                    orderData.analysis.updated_at }}</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <ValidationObserver ref="assigneeForm">
                <div class="group">
                    <p class="text-light-black mgb-12">Note from previous steps</p>
                    <p class="mb-0 text-light-black fw-bold" v-if="this.preNote.length">{{ this.preNote }}</p>
                    <p class="mb-0 text-light-black fw-bold" v-else>Note not updated yet</p>
                </div>
                <div v-if="assignToName.length">
                    <div class="mgb-32">
                        <div class="group">
                            <p class="text-light-black mgb-12">Assign to</p>
                            <p class="mb-0 text-light-black fw-bold">{{ assignToName }}</p>
                        </div>
                    </div>
                    <div class="mgb-32">
                        <div class="group">
                            <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                            <div class="preparation-input w-100 position-relative">
                                <text-editor placeholder="Add note..." v-model="note"></text-editor>
                            </div>
                        </div>
                    </div>
                    <div class="mgb-32 d-flex align-items-center">
                        <div class="checkbox-group review-check mgr-20">
                            <input type="radio" class="checkbox-input check-data" v-model="noteCheck" value="1">
                            <label for="" class="checkbox-label text-capitalize">Rewrite & send back</label>
                        </div>
                        <div class="checkbox-group review-check">
                            <input type="radio" class="checkbox-input check-data" v-model="noteCheck" value="2">
                            <label for="" class="checkbox-label text-capitalize">Check & upload</label>
                        </div>
                    </div>
                    <!-- upload -->
                    <div>
                        <p class="text-light-black mgb-12">Files</p>
                        <div class="position-relative file-upload">
                            <input type="file" multiple v-on:change="addFiles">
                            <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span
                                        class="path1"></span><span class="path2"></span><span
                                        class="path3"></span></span></label>
                        </div>
                        <p class="text-light-black mgb-12" v-if="fileData.files.length">{{ fileData.files.length }}
                            Files</p>
                    </div>
                    <div class="text-end mgt-32">
                        <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveFinalData" :disabled="isUploading">Done</button>
                        <button class="button button-close px-4 h-40 d-inline-flex align-items-center" @click="isDataExists = true">Close</button>
                    </div>
                </div>
                <div v-else>
                    <div class="mgb-32">
                        <ValidationProvider class="group" name="Assign to" rules="required" v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Assign to </label>
                                <!-- <select name="" class="dashboard-input w-100 loan-type-select" v-model="assignTo">
                                <option value="">Please Select a user</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select> -->
                                <m-select theme="blue" :options="users" object item-text="name" item-value="id"
                                    v-model="assignTo"></m-select>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="text-end mgt-32">
                        <button class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                            @click="saveAssigneeData">Assign</button>
                    </div>
                </div>

            </ValidationObserver>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'ReportAnalysisReview',
        props: {
            order: [],
            users: Array,
        },
        data: () => ({
            isUploading: false,
            orderData: [],
            isDataExists: false,
            assignToName: '',
            assignTo: '',
            preNote: '',
            note: '',
            noteCheck: '',
            fileData: {
                file_type: '',
                files: [],
            },
            message: '',
        }),
        created() {
            let order = this.order;
            let localOrderData = this.$store.getters['app/orderDetails']
            if (localOrderData) {
                order = localOrderData;
            }
            this.updateData(order)
        },
        methods: {
            addFiles(event) {
                this.fileData.files = event.target.files
            },
            updateData(order) {
                this.orderData = order
                this.isDataExists = false
                let initReview = !_.isEmpty(this.orderData.initial_review) ? this.orderData.initial_review : false;
                if (initReview) {
                    this.preNote = initReview.note
                }
                let analysis = this.orderData.analysis;
                if (analysis) {
                    this.assignTo = analysis.assigned_to
                    this.assignToName = analysis.assignee.name
                    if (analysis.is_review_send_back) {
                        this.noteCheck = 1
                        this.note = analysis.rewrite_note
                    }
                    if (analysis.is_check_upload) {
                        this.noteCheck = 2
                        this.note = analysis.note
                    }
                }
                if (this.assignToName) {
                    this.isDataExists = true
                }
            },
            saveAssigneeData() {
                this.isUploading = true
                this.$refs.assigneeForm.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        formData.append('assigned_to', this.assignTo)
                        this.$boston.post('report-analysis-create/' + this.orderData.id, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res => {
                            this.isUploading = false
                            this.fileData.file_type = ''
                            this.fileData.files = []
                            this.isDataExists = true
                            if (res.error == false) {
                                this.orderData = res.data
                                this.$root.$emit('wk_flow_menu', this.orderData);
                                this.$root.$emit('wk_update', this.orderData);
                                this.updateData(this.orderData);
                            }
                            this.$root.$emit('wk_flow_toast', res)
                        }).catch(err => {
                        });
                    } else {
                        this.isUploading = false
                    }
                })
            },
            saveFinalData() {
                if (this.orderData.analysis.attachments?.length == 0 && !this.fileCheck(this.fileData.files)) {
                    return false;
                }
                this.isUploading = true;
                this.$refs.assigneeForm.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        for (let i = 0; i < this.fileData.files.length; i++) {
                            let file = this.fileData.files[i];
                            formData.append('files[' + i + ']', file);
                        }
                        formData.append('file_type', this.fileData.file_type)
                        formData.append('note', this.note)
                        formData.append('noteCheck', this.noteCheck)
                        this.$boston.post('report-analysis-create/' + this.orderData.id, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res => {
                            this.isUploading = false
                            this.fileData.file_type = ''
                            this.fileData.files = []
                            this.isDataExists = true
                            if (res.error == false) {
                                this.orderData = res.data
                                this.$root.$emit('wk_flow_menu', this.orderData);
                                this.$root.$emit('wk_update', this.orderData);
                                this.updateData(this.orderData);
                            }
                            this.$root.$emit('wk_flow_toast', res)
                        }).catch(err => {
                        });
                    } else {
                        this.isUploading = false
                    }
                })
            }
        }
    }
</script>
