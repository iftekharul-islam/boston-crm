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
                <select name="" class="dashboard-input w-100 loan-type-select creatorId" v-model="creatorId">
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
                <select name="" class="dashboard-input w-100 loan-type-select viewerId" v-model="viewerId">
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
            <a class="edit-btn" @click="dataExist = false; initSelect2();"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
            <div class="group">
              <p class="text-light-black mgb-12">Report creator</p>
              <p class="mb-0 text-light-black fw-bold">{{ this.creator }}</p>
            </div>
            <div class="group">
              <p class="text-light-black mgb-12">Report reviewer</p>
              <p class="mb-0 text-light-black fw-bold">{{ this.viewer }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Assigne to</p>
                <p class="mb-0 text-light-black fw-bold">{{ this.assignToName }}</p>
            </div>
            <div class="group">
              <p class="text-light-black mgb-12">Trainee to</p>
              <p class="mb-0 text-light-black fw-bold">{{ this.trainee }}</p>
            </div>
            <div class="group">
              <p class="text-light-black mgb-12">Note</p>
              <p class="mb-0 text-light-black fw-bold">{{ this.note }}</p>
            </div>
            <div class="group"  v-if="dataFiles.length">
                <p class="text-light-black mgb-12">Report preparation file upload</p>
                <div class="document">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3" v-for="(file, key) in dataFiles" :key="key">
                            <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12 file-name">
                                <a :href="file.original_url" download>{{ file.name }}</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        <div v-else-if="isEmpty">-->
<!--          <div class="group text-center">-->
<!--              <p class="text-light-black mgb-12">Admin not updated yet</p>-->
<!--            </div>-->
<!--        </div>-->
        <div v-else>
<!--            <div class="group">-->
<!--              <p class="text-light-black mgb-12">Report creator</p>-->
<!--              <p class="mb-0 text-light-black fw-bold">{{ this.creator }}</p>-->
<!--            </div>-->
<!--            <div class="group">-->
<!--              <p class="text-light-black mgb-12">Report reviewer</p>-->
<!--              <p class="mb-0 text-light-black fw-bold">{{ this.viewer }}</p>-->
<!--            </div>-->
            <ValidationObserver ref="assigneeForm">
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Report Creator" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Report Creator </label>
                            <!-- <select name="" class="dashboard-input w-100 loan-type-select creatorId" @change="changeSelect('creatorId', $event.target.value)" v-model="creatorId">
                                <option value="">Please Select a user</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select> -->
                            <m-select :options="users" object item-text="name" item-value="id" v-model="creatorId"></m-select>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Report Viewer" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Report Viewer </label>
                            <!-- <select name="" class="dashboard-input w-100 loan-type-select viewerId" @change="changeSelect('viewerId', $event.target.value)" v-model="viewerId">
                                <option value="">Please Select a user</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select> -->
                            <m-select :options="users" object item-text="name" item-value="id" v-model="viewerId"></m-select>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Assign to" rules="required" v-slot="{ errors }">
                      <div :class="{ 'invalid-form' : errors[0] }">
                        <label for="" class="d-block mb-2 dashboard-label">Assign to </label>
                        <!-- <select name="" class="dashboard-input w-100 loan-type-select assignTo" v-model="assignTo" @change="changeSelect('assignTo', $event.target.value)">
                          <option value="">Please Select a user</option>
                          <option v-for="user in users" :key="user.id" :value="user.id">
                              {{ user.name }}
                          </option>
                        </select> -->
                        <m-select :options="users" object item-text="name" item-value="id" v-model="assignTo"></m-select>
                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                      </div>
                    </ValidationProvider>
                  </div>
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Trainee Selection" rules="required" v-slot="{ errors }">
                      <div :class="{ 'invalid-form' : errors[0] }">
                        <label for="" class="d-block mb-2 dashboard-label">Trainee Selection </label>
                        <!-- <select name="" class="dashboard-input w-100 loan-type-select traineeId" v-model="traineeId" @change="changeSelect('traineeId', $event.target.value)">
                          <option value="">Please Select a user</option>
                          <option v-for="user in users" :key="user.id" :value="user.id">
                              {{ user.name }}
                          </option>
                        </select> -->
                        <m-select theme="blue" :options="users" object item-text="name" item-value="id" v-model="traineeId"></m-select>
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
                  <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveAssigneeData" :disabled="isUploading">Done</button>
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
    isUploading: false,
    orderData: [],
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
    assignToName: '',
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
      },
    updateAdmin() {
      let report = !_.isEmpty(this.orderData.report) ? this.orderData.report : false;
      if(report){
        this.creator = !_.isEmpty(report.creator) ? report.creator.name : '',
        this.viewer = !_.isEmpty(report.reviewer) ? report.reviewer.name : '',
        this.trainee = !_.isEmpty(report.trainee) ? report.trainee.name : '',
        this.assignToName = !_.isEmpty(report.assignee) ? report.assignee.name : '',
        this.creatorId = report.creator_id
        this.viewerId = report.reviewed_by
        this.assignTo = report.assigned_to
        this.traineeId = report.trainee_id
        this.note = report.note
        this.dataFiles = !_.isEmpty(this.orderData.preparation_files) ? this.orderData.preparation_files : [];
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
            if (status) {
                const data = {
                    'creator_id': this.creatorId,
                    'reviewed_by': this.viewerId
                }
                this.$boston.post('admin-report-preparation-create/' + this.orderData.id, data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(res => {
                    this.isUploading = false
                    this.fileData.files = []
                    this.orderData = res.data;
                    this.updateAdmin();
                    this.$root.$emit('wk_update', this.orderData);
                    this.$root.$emit('wk_flow_menu', this.orderData);
                    this.$root.$emit('wk_flow_toast', res);
                }).catch(err => {
                    this.isUploading = false
                });
            } else {
                this.isUploading = false
            }
        })
    },
    saveAssigneeData() {
        this.isUploading = true
        this.$refs.assigneeForm.validate().then((status) => {
          if(status) {
              let formData = new FormData();
              for( let i = 0; i < this.fileData.files.length; i++ ){
                  let file = this.fileData.files[i];
                  formData.append('files[' + i + ']', file);
              }
              formData.append('file_type', this.fileData.file_type)
              formData.append('assigned_to', this.assignTo)
              formData.append('note', this.note)
              formData.append('trainee_id', this.traineeId)
              formData.append('creator_id', this.creatorId)
              formData.append('reviewed_by', this.viewerId)
            this.$boston.post('assignee-report-preparation-create/'+ this.orderData.id, formData, { headers: {
                    'Content-Type': 'multipart/form-data'
                }}).then(res => {
                this.isUploading = false
                this.fileData.files = []
                this.fileData.file_type = ''
                this.orderData = res.data;
                this.updateAdmin();
                this.$root.$emit('wk_update', this.orderData);
                this.$root.$emit('wk_flow_menu', this.orderData);
                this.$root.$emit('wk_flow_toast', res);
            }).catch(err => {
            });
          } else {
              this.isUploading = false
          }
      })
    },
    updateRole() {
      if (this.role == 'admin') {
        this.isAdmin = true
      }
    },
    changeSelect(type, value) {

    },
    initSelect2() {
      // $("select").select2();
      // $(".creatorId").on("select2:select", function(e){
      //   this.creatorId = e.target.value;
      // }.bind(this));
      // $(".viewerId").on("select2:select", function(e){
      //   this.viewerId = e.target.value;
      // }.bind(this));
      // $(".assignTo").on("select2:select", function(e){
      //   this.assignTo = e.target.value;
      // }.bind(this));
      // $(".traineeId").on("select2:select", function(e){
      //   this.traineeId = e.target.value;
      // }.bind(this));
    }
  },
  created() {
      let order = this.order;
      let localOrderData = this.$store.getters['app/orderDetails']
      if(localOrderData){
          order = localOrderData;
      }
      this.orderData = order;
      this.updateAdmin()
  },
  mounted() {
      this.initSelect2();
  }
}
</script>
