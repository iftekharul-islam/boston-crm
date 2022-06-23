<template>
    <div class="inspection-item step-items">
        <div v-if="isEmpty" class="scheduling-item step-items no-schedule">
            <p class="fs-20 fw-bold">Please Create schedule first ! No schedule is set.</p>
        </div>
        <div v-else>
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
                            <span class="text-light-black d-inline-block mgl-12 file-name">{{ file.name }}</span>
                        </div>
                    </div>
                </div>
                <!-- upload -->
                <div class="position-relative file-upload mgt-20" v-if="editable">
                    <p class="text-light-black mgb-12">Files</p>
                    <div class="position-relative file-upload">
                        <input type="file" multiple v-on:change="addFiles">
                        <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span
                            class="path1"></span><span class="path2"></span><span
                            class="path3"></span></span></label>
                    </div>
                    <p class="text-light-black mgb-12" v-if="fileData.files.length">{{ fileData.files.length }} Files</p>
                </div>
            </div>
            <div class="text-end mgt-32" v-if="editable">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveInsFiles"
                        :disabled="isUploading">Save</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'inspection-workflow',
        props: {
            order: [],
        },
        data: () => ({
            isUploading: false,
            isEmpty: false,
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
        }),
        created() {
            this.inspectionData(this.order)
        },
        methods: {
            inspectionData(order) {
                this.orderData = order;
                if (this.orderData.inspection !== null) {
                    this.id = this.orderData.inspection.id
                    this.note = this.orderData.inspection.note
                    this.name = this.orderData.inspection.user.name
                    this.dataFiles = this.orderData.inspection.attachments
                    this.editable = false
                } else {
                    this.isEmpty = true
                }
            },
            addFiles(event) {
                this.fileData.files = event.target.files
            },
            saveInsFiles() {
                this.isUploading = true
                this.editable = false
                let that = this
                let formData = new FormData();
                for (let i = 0; i < this.fileData.files.length; i++) {
                    let file = this.fileData.files[i];
                    formData.append('files[' + i + ']', file);
                }
                formData.append('file_type', this.fileData.file_type)
                this.$boston.post('upload-inspection-files/' + this.id, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    console.log(res)
                    this.isUploading = false
                    this.editable = false
                    if (res.error) {
                        this.$root.$emit('wk_flow_toast', res);
                    } else {
                        this.fileData.files = []
                        this.fileData.file_type = ''
                        this.orderData = res.data
                        this.$root.$emit('wk_update', res.data);
                        this.$root.$emit('wk_flow_menu', res.data);
                        this.$root.$emit('wk_flow_toast', res);
                        this.inspectionData(res.data)
                    }
                }).catch(err => {
                    console.log(err)
                    this.isUploading = false
                })
            }
        },
    }
</script>
