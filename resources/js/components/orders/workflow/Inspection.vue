<template>
    <div class="inspection-item step-items">
        <a class="edit-btn" v-if="!editable" @click="editable = true"><span class="icon-edit"><span
                    class="path1"></span><span class="path2"></span></span></a>
        <div class="group">
            <p class="text-light-black mgb-12">Appraiser</p>
            <p class="mb-0 text-light-black fw-bold">{{ name }}</p>
        </div>
        <div class="group">
            <p class="text-light-black mgb-12">Instruction or Note for Inspection</p>
            <p class="mb-0 text-light-black fw-bold">{{ note }}</p>
        </div>
        <div class="group">
            <p class="text-light-black mgb-12">Inspection file upload</p>
            <div class="document">
                <div class="row" v-if="dataFiles.length">
                    <div class="d-flex align-items-center mb-3" v-for="file, ki in dataFiles" :key="ki">
                        <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                        <span class="text-light-black d-inline-block mgl-12">{{ file.name }}</span>
                    </div>
                </div>
            </div>
            <!-- upload -->
            <div class="position-relative file-upload mgt-20" v-if="editable">
                <div v-b-modal.upload-ins-files class="position-relative file-upload document-upload">
                    <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
                </div>
            </div>
        </div>
        <div class="text-end mgt-32" v-if="editable">
            <button class="button button-primary px-4 h-40 d-inline-flex align-items-center">Save</button>
        </div>
        <b-modal id="upload-ins-files" size="lg" title="Uploads Inspection Files">
            <div class="modal-body">
                <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a>
                </b-alert>
                <div class="row">
                    <div class="col-md-6">
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Select file <span
                                    class="require"></span></label>
                            <input type="file" multiple v-on:change="addFiles">
                        </div>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button variant="secondary" @click="$bvModal.hide('upload-ins-files')">Close</b-button>
                <b-button variant="primary" @click="saveInsFiles">Save</b-button>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: 'inspection-workflow',
        props: {
            order: [],
        },
        data: () => ({
            editable: true,
            orderData: [],
            fileData: {
                id: null,
                name: '',
                note: '',
                file_type: '',
                files: [],
            },
            name: null,
            note: null,
            dataFiles: [],
            message: ''
        }),
        created() {
            this.inspectionData(this.order);
        },
        methods: {
            inspectionData(order) {
                this.orderData = order;
                if(this.orderData.inspection !== null){
                    this.id = this.orderData.inspection.id
                    this.note = this.orderData.inspection.note
                    this.name = this.orderData.inspection.user.name
                    this.dataFiles = this.orderData.inspection.attachments
                    this.editable = false
                }
            },
            addFiles(event) {
                this.fileData.files = event.target.files
            },
            saveInsFiles() {
                this.editable = false
                let that = this
                let formData = new FormData();
                for (let i = 0; i < this.fileData.files.length; i++) {
                    let file = this.fileData.files[i];
                    formData.append('files[' + i + ']', file);
                }
                formData.append('file_type', this.fileData.file_type)
                axios.post('upload-inspection-files/' + this.id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    this.fileData = []
                    this.orderData = res.data.data
                    this.message = res.data.message
                    this.$root.$emit('wk_update', this.orderData);
                    this.$root.$emit('wk_flow_menu', this.orderData);
                    this.$root.$emit('wk_flow_toast', res);
                    this.inspectionData()
                    setTimeout(function () {
                        that.$bvModal.hide('upload-ins-files')
                        that.message = ''
                    }, 2000);
                }).catch(err => {
                })
            }
        },
    }
</script>
