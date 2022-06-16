<template>
  <div class="report-analysis-item step-items">
    <div v-if="isEditable">
        <ValidationObserver ref="assigneeForm">
            <div class="group">
                <p class="text-light-black mgb-12">Note from previous steps</p>
                <p class="mb-0 text-light-black fw-bold">{{ this.preNote }}</p>
            </div>
            <div class="mgb-32">
                <ValidationProvider class="group" name="Assign to" rules="required" v-slot="{ errors }">
                    <div :class="{ 'invalid-form' : errors[0] }">
                        <label for="" class="d-block mb-2 dashboard-label">Assign to </label>
                        <select name="" class="dashboard-input w-100 loan-type-select" v-model="assignTo">
                            <option value="">Please Select a user</option>
                            <option v-for="user in users" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                    </div>
                </ValidationProvider>
            </div>
            <div class="mgb-32">
                <ValidationProvider class="group" name="Note" rules="required" v-slot="{ errors }">
                    <div :class="{ 'invalid-form' : errors[0] }">
                        <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                        <div class="preparation-input w-100 position-relative">
                            <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea" v-model="note"></textarea>
                        </div>
                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                    </div>
                </ValidationProvider>
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
                    <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                </div>
                <p class="text-light-black mgb-12" v-if="fileData.files.length">{{ fileData.files.length }} Files</p>
            </div>
            <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveAssigneeData">Done</button>
            </div>
        </ValidationObserver>
    </div>
    <div v-else>
        <a class="edit-btn" @click="isEditable = true"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
        <div class="group">
            <p class="text-light-black mgb-12">Note from previous steps</p>
            <p class="mb-0 text-light-black fw-bold">{{ this.preNote }}</p>
        </div>
        <div class="group" v-if="noteCheck == 1">
            <p class="text-light-black mgb-12">Note from this step</p>
            <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
            <p class="mb-0 text-light-black fw-bold">{{ note }}</p>
        </div>
        <div class="group" v-if="noteCheck == 2">
            <p class="text-light-black mgb-12">Note from this step</p>
            <a href="#" class="primary-text mb-2">(Check & Upload)</a>
            <p class="mb-0 text-light-black fw-bold">{{ note }}</p>
        </div>
        <div class="group">
            <p class="text-light-black mgb-12">Assign to</p>
            <p class="mb-0 text-light-black fw-bold">{{ assignToName }}</p>
        </div>
        <div class="group">
            <p class="text-light-black mgb-12">Analysis file upload</p>
            <div class="document">
                <div class="row">
                    <div class="d-flex align-items-center mb-3" v-for="file in dataFiles">
                        <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                        <span class="text-light-black d-inline-block mgl-12">{{ file.name }}</span>
                    </div>
                </div>
            </div>

        </div>
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
    isEditable: true,
    assignToName: '',
    assignTo: '',
    preNote: '',
    note: '',
    noteCheck: '',
    fileData:{
      file_type: '',
      files: [],
    },
    dataFiles: [],
    message: '',
  }),
  methods: {
    addFiles(event){
      this.fileData.files = event.target.files
        console.log(this.files)
    },
    saveFiles(){
          this.editable = false
          let that = this
          let formData = new FormData();
          for( let i = 0; i < this.fileData.files.length; i++ ){
              let file = this.files[i];
              formData.append('files[' + i + ']', file);
          }
          formData.append('file_type',this.fileData.file_type)
          axios.post('upload-inspection-files/'+ this.id, formData,{ headers: {
                  'Content-Type': 'multipart/form-data'
              }})
              .then(res => {
                  console.log('response', res.data)
                  this.fileData = []
              }).catch(err => {
              console.log(err)
          })
      },
    updateData(){
      let report = !_.isEmpty(this.order.report) ? this.order.report : false;
      if(report){
        this.preNote = report.note
      }
      let analysis = !_.isEmpty(this.order.analysis) ? this.order.analysis : false;
      if(analysis){
          this.assignToName = analysis.assignee.name
          this.dataFiles = analysis.attachments
          if(analysis.is_review_send_back){
              this.noteCheck = 1
              this.note = analysis.rewrite_note
          }
          if(analysis.is_check_upload){
              this.noteCheck = 2
              this.note = analysis.note
          }
      }
      if(this.assignToName || this.note){
          this.isEditable = false
      }
    },
    saveAssigneeData() {
        this.$refs.assigneeForm.validate().then((status) => {
          if(status) {
            console.log(status)
            console.log('hello')
            let formData = new FormData();
            for( let i = 0; i < this.fileData.files.length; i++ ){
              let file = this.fileData.files[i];
              formData.append('files[' + i + ']', file);
            }
            formData.append('file_type', this.fileData.file_type)
            formData.append('assigned_to', this.assignTo)
            formData.append('note', this.note)
            formData.append('noteCheck', this.noteCheck)
            this.$boston.post('report-analysis-create/'+ this.order.id, formData, { headers: {
                    'Content-Type': 'multipart/form-data'
                }}).then(res => {
                this.fileData = []
                console.log('response', res)
                this.isEditable = false
            }).catch(err => {
                console.log('err', err)
            });
          }
      })
    },
  },
  created() {
    this.updateData()
    console.log(this.order)
    console.log(this.users)
  },

}
</script>
