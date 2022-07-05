<template>
    <div class="row ">
        <div class="col-12">
            <!-- Files -->
            <div class="order-details-box bg-white">
                <div class="box-header">
                    <p class="fw-bold text-light-black fs-20 mb-0">Files</p>
                    <div class="group">
                        <div v-b-modal.upload-files class="position-relative file-upload document-upload">
                            <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <!-- document -->
                    <div class="document">
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3" v-for="(files,type) in allFiles" :key="type">
                                <p class="fw-bold text-light-black">{{ type }}</p>
                                <div class="d-flex align-items-center mb-3" v-for="file in files">
                                    <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                    <div class="mgl-12">
                                        <span class="text-light-black mb-0 file-name d-block"><a
                                            :href="file.original_url" download class="text-light-black">{{ file.name }}</a></span>
                                        <p class="text-gray fs-12 mb-0">Uploaded: {{ getUserName(file.custom_properties) + ', '}}{{  file.created_at | momentTime  }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <b-modal id="upload-files" size="lg" title="Uploads Order Files">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ValidationObserver class="group d-block" ref="fileForm">
                            <ValidationProvider class="group d-block" name="File type" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Select file type <span
                                            class="require"></span></label>
                                    <b-form-select v-model="fileData.file_type" :options="orderFileTypes"
                                        class="dashboard-input w-100">
                                        <template #first>
                                            <b-form-select-option value="" disabled>-- Please select an option --
                                            </b-form-select-option>
                                        </template>
                                    </b-form-select>
                                </div>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </ValidationObserver>
                        <span class="group d-block">
                             <label for="" class="d-block mb-2 dashboard-label">Select file <span class="require"></span></label>
                            <div class="position-relative file-upload">
                                <input type="file" multiple v-on:change="addFiles">
                                <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button variant="secondary" @click="$bvModal.hide('upload-files')">Close</b-button>
                <b-button variant="primary" @click="saveOrderFiles">Save</b-button>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: {
            order: [],
            orderFileTypes: [],
            orderFiles: []
        },
        data() {
            return {
                fileData: {
                    file_type: '',
                    files: [],
                },
                allFiles: [],
                orderData: [],
            }
        },
        created() {
            this.getFiles(this.orderFiles, this.order)
            console.log(this.orderData)
        },
        methods: {
            formatedDate(date){
                let dt =  new Date(date)
                let day =  dt.getDate()
                let month =  dt.getMonth()
                let year = dt.getFullYear()
                let hour = dt.getHours()
                let minute = dt.getMinutes()
                return day+'-'+month+'-'+year+' '+hour+':'+minute
            },
            getUserName(fileObj){
                let user = fileObj.user
                return user ?? ''
            },
            getFiles(files, order) {
                this.allFiles = files
                this.orderData = order
            },
            addFiles(event) {
                this.fileData.files = event.target.files
            },
            saveOrderFiles() {
                this.$refs.fileForm.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        for (let i = 0; i < this.fileData.files.length; i++) {
                            let file = this.fileData.files[i];
                            formData.append('files[' + i + ']', file);
                        }
                        formData.append('file_type', this.fileData.file_type)
                        this.$boston.post('upload-order-files/' + this.orderData.id, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res => {
                            this.orderData = res.data
                            this.$root.$emit('wk_update', res.data)
                            this.$root.$emit('wk_flow_toast', res)
                            this.getFiles(res.orderFiles, this.orderData)
                            this.$bvModal.hide('upload-files')
                        }).catch(err => {
                            console.log(err)
                        })
                    }
                })
            }
        }
    }
</script>
