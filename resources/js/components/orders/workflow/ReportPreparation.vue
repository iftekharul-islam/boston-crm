<template>
  <div class="report-preparation-item step-items">
    <div v-if="isAdmin">
      <div v-if="adminDataExist">
        <a class="edit-btn" @click="adminDataExist = false"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
        <div class="group">
          <p class="text-light-black mgb-12">Report creator</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.creator }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Report reviewer</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.viewer }}</p>
        </div>
      </div>
      <div v-else>
        <ValidationObserver ref="adminForm">
          <div class="mgb-32">
            <ValidationProvider class="group" name="Report Creator" rules="required" v-slot="{ errors }">
              <div :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Report Creator </label>
                <select name="" class="dashboard-input w-100 loan-type-select" v-model="creatorId">
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
            <ValidationProvider class="group" name="Report Viewer" rules="required" v-slot="{ errors }">
              <div :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Report Viewer </label>
                <select name="" class="dashboard-input w-100 loan-type-select" v-model="viewerId">
                  <option value="">Please Select a user</option>
                  <option v-for="user in users" :key="user.id" :value="user.id">
                      {{ user.name }}
                  </option>
                </select>
                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
              </div>
            </ValidationProvider>
          </div>
          <div class="text-end mgt-32">
            <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveAdminData">Save</button>
          </div>
        </ValidationObserver>
      </div>
    </div>
    <div v-else>
      <div v-if="dataExist">
        <a class="edit-btn" @click="dataExist = false"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
        <div class="group">
          <p class="text-light-black mgb-12">Report creator</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.creator }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Report reviewer</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.viewer }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Traineee</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.trainee }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Note</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.note }}</p>
        </div>
          <div class="group">
              <p class="text-light-black mgb-12">Report preparation file upload</p>
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
    <div v-else-if="isEmpty">
      <div class="group text-center">
          <p class="text-light-black mgb-12">Admin not udpated yet</p>
        </div>
    </div>
    <div v-else>
        <div class="group">
          <p class="text-light-black mgb-12">Report creator</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.creator }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Report reviewer</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.viewer }}</p>
        </div>
        <ValidationObserver ref="assigneeForm">
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
                <ValidationProvider class="group" name="Trainee Selection" rules="required" v-slot="{ errors }">
                  <div :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Trainee Selection </label>
                    <select name="" class="dashboard-input w-100 loan-type-select" v-model="traineeId">
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
    </div>
  </div>
</template>
<script>
export default {
  name: 'ReportPreparation',
  props: {
    users: Array,
    role: String,
    order: [],
  },
  data: () => ({
    isEmpty: false,
    adminDataExist: true,
    dataExist: true,
    creator: '',
    viewer: '',
    trainee: '',
    isAdmin: false,
    creatorId: '',
    viewerId: '',
    traineeId: '',
    assignTo: '',
    note: '',
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
    updateAdmin() {
      let report = !_.isEmpty(this.order.report) ? this.order.report : false;
      if(report){
        this.creator = !_.isEmpty(report.creator) ? report.creator.name : '',
        this.viewer = !_.isEmpty(report.reviewer) ? report.reviewer.name : '',
        this.trainee = !_.isEmpty(report.assignee) ? report.assignee.name : '',
        this.creatorId = report.creator_id
        this.viewerId = report.reviewed_by
        this.assignTo = report.assigned_to
        this.traineeId = report.trainee_id
        this.note = report.note
        this.dataFiles = report.attachments
      }
      if(this.creator || this.viewer){
        this.isEmpty = false
        this.adminDataExist = true;
      } else {
        this.isEmpty = true
        this.adminDataExist = false;
      }
      if(this.trainee || this.note){
        this.dataExist = true
      } else {
        this.dataExist = false
      }
    },
    saveAdminData() {
        this.$refs.adminForm.validate().then((status) => {
        if(status) {
          console.log('hello')
          const data = {
            'creator_id': this.creatorId,
            'reviewed_by': this.viewerId
          }
          console.log(data)
          this.$boston.post('admin-report-preparation-create/'+ this.order.id, formData, { headers: {
                  'Content-Type': 'multipart/form-data'
              }}).then(res => {
              console.log('response', res)
              this.adminDataExist = true;
          }).catch(err => {
              console.log('err', err)
          });
        }

      })
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
              formData.append('trainee_id', this.traineeId)
            const data = {
              'note': this.note,
              'assigned_to': this.assignTo,
              'trainee_id': this.traineeId,
            }
            console.log(data)
            this.$boston.post('assignee-report-preparation-create/'+ this.order.id, formData, { headers: {
                    'Content-Type': 'multipart/form-data'
                }}).then(res => {
                console.log('response', res)
                this.dataExist = true
            }).catch(err => {
                console.log('err', err)
            });
          }
      })
    },
    updateRole() {
      if (this.role == 'admin') {
        this.isAdmin = true
      }
    }
  },
  created() {
    this.updateRole();
    this.updateAdmin()
    console.log(this.order)
  },
}
</script>
