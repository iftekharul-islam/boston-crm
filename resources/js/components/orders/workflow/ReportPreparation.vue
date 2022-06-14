<template>
  <div class="report-preparation-item step-items">
    <div v-if="isAdmin">
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
    <div v-else>
    <div v-if="userEdit">
        <a class="edit-btn" @click="userEdit = false"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
        <div class="group">
          <p class="text-light-black mgb-12">Report creator</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.order.report.creator.name }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Report reviewer</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.order.report.reviewer.name }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Traineee</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.order.report.trainee.name }}</p>
        </div>
        <div class="group">
          <p class="text-light-black mgb-12">Note</p>
          <p class="mb-0 text-light-black fw-bold">{{ this.order.report.note }}</p>
        </div>
    </div>
    <div v-else>
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
          <div class="mgb-32">
            <label for="" class="mb-2 text-light-black d-inline-block">Files</label>
            <!-- upload -->
            <div class="position-relative file-upload mgt-20">
              <input type="file">
              <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
            </div>
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
    userEdit: false,
    isAdmin: false,
    creatorId: '',
    viewerId: '',
    traineeId: '',
    assignTo: '',
    note: '',
  }),
  methods: {
    saveAdminData() {
        this.$refs.adminForm.validate().then((status) => {
            console.log(status)
            console.log('hello')
            const data = {
              'creator_id': this.creatorId,
              'reviewed_by': this.viewerId
            }
            console.log(data)
           this.$boston.post('admin-report-preparation-create/'+ this.order.id, data).then(res => {
              console.log('response', res)
          }).catch(err => {
              console.log('err', err)
          });
            
      })
    },
    saveAssigneeData() {
        this.$refs.assigneeForm.validate().then((status) => {
            this.userEdit = true,
            console.log(status)
            console.log('hello')
            const data = {
              'note': this.note,
              'assigned_to': this.assignTo,
              'trainee_id': this.traineeId,
            }
            console.log(data)
           this.$boston.post('assignee-report-preparation-create/'+ this.order.id, data).then(res => {
              console.log('response', res)
          }).catch(err => {
              console.log('err', err)
          });
            
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
    console.log(this.order)
  },
}
</script>
