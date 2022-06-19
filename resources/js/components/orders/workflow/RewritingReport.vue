<template>
  <div id="rewrite-section">
    <div class="step-non-ediable" v-if="!editable">
      <ValidationObserver ref="rewritingReport">
        <div class="re-writing-report-item step-items">
          <div class="group">
            <p class="text-light-black mgb-12">Note from previous stpes</p>
            <p class="mb-0 text-light-black fw-bold" v-html="prev.rewrite_note"></p>
          </div>

          <div class="group" v-if="current.note">
            <p class="text-light-black mgb-12">Note from this step</p>
            <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
            <p class="mb-0 text-light-black fw-bold" v-html="current.note"></p>
          </div>

          <div class="mgb-32">
            <ValidationProvider class="group" name="Assign to" rules="required" v-slot="{ errors }">
              <div :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                <div class="preparation-input w-100 position-relative">
                  <select v-model="assigned_to" class="w-100 dashboard-input">
                    <option>Choose Assingee</option>
                    <option v-for="user in usersInfo" :key="user.id" :value="user.id">
                        {{ user.name }}
                    </option>
                  </select>
                  <span class="icon-arrow-down bottom-arrow-icon"></span>
                </div>
              </div>
            </ValidationProvider>
          </div>

          <div class="group">
            <p class="text-light-black mgb-12">Files From Previous Step</p>
            <div class="row">
              <div class="d-flex align-items-center mb-3" v-for="file, fileIndex in dataFiles" :key="fileIndex">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">{{ file.name }}</span>
              </div>
            </div>
          </div>

          <div class="mgb-20">
            <ValidationProvider class="group" name="Choose Notes" rules="required" v-slot="{ errors }">
              <div :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                  <div class="preparation-input w-100 position-relative">
                    <textarea v-model="note" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                  </div>
              </div>
            </ValidationProvider>
          </div>

          <div class="text-end mgt-32">
            <button v-if="current.note" class="button button-danger px-4 h-40 d-inline-flex align-items-center" @click="editable = true">Close</button>
            <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveAssigneeData">Done</button>
          </div>
        </div>
      </ValidationObserver>
    </div>
    <div class="step-editable" v-else>
      <ValidationObserver>
        <div class="re-writing-report-item step-items">
          <a class="edit-btn" @click="editable = false"><span class="icon-edit"><span class="path1"></span><span class="path2"></span></span></a>
          <div class="group">
            <p class="text-light-black mgb-12">Note from previous stpes</p>
            <p class="mb-0 text-light-black fw-bold" v-html="prev.rewrite_note"></p>
          </div>
          <div class="group">
            <p class="text-light-black mgb-12">Note from this step</p>
            <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
            <p class="mb-0 text-light-black fw-bold" v-html="current.note"></p>
          </div>
          <div class="group">
            <p class="text-light-black mgb-12">Assign to</p>
            <p class="mb-0 text-light-black fw-bold">{{ current.assignee.name }}</p>
          </div>

          <div class="group">
            <p class="text-light-black mgb-12">Files From Previous Step</p>
            <div class="row">
              <div class="d-flex align-items-center mb-3" v-for="file, fileIndex in dataFiles" :key="fileIndex">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">{{ file.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </ValidationObserver>
    </div>
  </div>
</template>
<script>
export default {
  name: 'RewritingReport',
  props: ['order'],
  data: () => ({
      orderData: [],
      prev: [],
      current: [],
      dataFiles: [], 
      note: null,
      assigned_to: null,
      editable: false,
  }),
  inject: ['usersInfo'],
  created(){
      this.orderData = this.order;
      this.initData(this.orderData);

      this.$root.$on("wk_update", (res) => {
          this.initData(res);
      });
  },  
  methods: {
      initData(order){
          console.log(order.analysis);
          this.prev = order.analysis ?? [];
          this.current = order.report_rewrite ?? [];

          this.dataFiles = this.prev.attachments;
          if (this.current.note) {
              this.assigned_to = this.current.assigned_to;
              this.note = this.current.note;
              this.editable = true;
          }
      },
      saveAssigneeData() {
        this.$refs.rewritingReport.validate().then((status) => {
            if(status) {
                const data = {
                  'note': this.note,
                  'assigned_to': this.assigned_to,
                  'order_id' : this.orderData.id
                }
                this.$boston.post('rewrite-report/update/', data, { headers: {
                        'Content-Type': 'multipart/form-data'
                    }}).then(res => {
                    this.orderData = res.data;
                    this.editable = true;
                    this.initData(this.orderData);
                    this.$root.$emit('wk_update', this.orderData);
                    this.$root.$emit('wk_flow_menu', this.orderData);
                }).catch(err => {
                    console.log('err', err)
                });
            }
        })
    },
  }
}
</script>

<style scoped>
.invalid-form textarea, .invalid-form select{
    border: thin solid #c44!important;
}
.invalid-form label {
    color:rgb(238, 80, 80)!important;
}
</style>