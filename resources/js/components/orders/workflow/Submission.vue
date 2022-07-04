<template>
  <div class="re-writing-report-item step-items ">
      <div v-if="isEditable">
          <ValidationObserver ref="submissionForm">
              <div class="mgb-32">
                  <ValidationProvider class="group" name="Trainee Selection" rules="required" v-slot="{ errors }">
                      <div :class="{ 'invalid-form' : errors[0] }">
                          <label for="" class="d-block mb-2 dashboard-label">Trainee name </label>
                          <!-- <select name="" class="dashboard-input w-100 loan-type-select" v-model="traineeId">
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
                  <div class="group">
                      <p class="text-light-black mgb-12">Quality assureance</p>
                      <p class="mb-0 text-light-black fw-bold" v-if="qaName.length">{{ qaName }}</p>
                      <p class="mb-0 text-light-black fw-bold" v-else>Not assigned yet</p>
                  </div>
              </div>
              <div class="mgb-32">
                  <ValidationProvider class="group" name="Delivery man" rules="required" v-slot="{ errors }">
                      <div :class="{ 'invalid-form' : errors[0] }">
                          <label for="" class="d-block mb-2 dashboard-label">Delivery by </label>
                          <!-- <select name="" class="dashboard-input w-100 loan-type-select" v-model="dManId">
                              <option value="">Please Select a user</option>
                              <option v-for="user in users" :key="user.id" :value="user.id">
                                  {{ user.name }}
                              </option>
                          </select> -->
                          <m-select theme="blue" :options="users" object item-text="name" item-value="id" v-model="dManId"></m-select>
                          <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                      </div>
                  </ValidationProvider>
              </div>
              <div class="mgb-20">
                  <ValidationProvider name="Date & time" rules="required" v-slot="{ errors }">
                      <div class="group" :class="{ 'invalid-form' : errors[0] }">
                          <label>Delivery date</label>
                          <div class="position-relative">
                              <input type="date" v-model="deliveryDate" class="dashboard-input w-100 gray-border">
                              <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                                  class="path3"></span><span class="path4"></span><span class="path5"></span><span
                                  class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                          </div>
                          <span class="error-message">{{ errors[0] }}</span>
                      </div>
                  </ValidationProvider>
              </div>
              <div>
                  <div class="checkbox-group review-check mgt-20">
                      <input type="checkbox" class="checkbox-input check-data" v-model="isAssineed">
                      <label for="" class="checkbox-label text-capitalize">Check it, if trainee signed. </label>
                  </div>
              </div>
              <div class="text-end mgt-32">
                  <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveAssigneeData">Deliver</button>
              </div>
          </ValidationObserver>
      </div>
      <div v-else>
          <a class="edit-btn"><span class="icon-edit" @click="isEditable = true"><span class="path1"></span><span class="path2"></span></span></a>
          <div class="group">
              <p class="text-light-black mgb-12">Trainee name</p>
              <p class="mb-0 text-light-black fw-bold">{{ traineeName }}</p>
          </div>
          <div class="group">
              <p class="text-light-black mgb-12">Quality assureance</p>
              <p class="mb-0 text-light-black fw-bold" v-if="qaName.length">{{ qaName }}</p>
              <p class="mb-0 text-light-black fw-bold" v-else>Not assigned yet</p>
          </div>
          <div class="group">
              <p class="text-light-black mgb-12">Delivered by</p>
              <p class="mb-0 text-light-black fw-bold">{{ dManName }}</p>
          </div>
          <div class="group">
              <p class="text-light-black mgb-12">Delivery date</p>
              <p class="mb-0 text-light-black fw-bold">{{ deliveryDate | onlyDate }}</p>
          </div>
          <div class="group">
              <div class="checkbox-group submission-check mgt-20">
                  <input type="checkbox" class="checkbox-input check-data" v-model="isAssineed" disabled>
                  <label for="" class="checkbox-label text-capitalize">Trainee assigned</label>
              </div>
          </div>
      </div>
  </div>
</template>
<script>
export default {
    name: 'Submission',
    props: {
        order: [],
        users: Array,
    },
    data: () => ({
        orderData: [],
        isEditable: true,
        traineeId: '',
        traineeName: '',
        dManId: '',
        dManName: '',
        assignToName: '',
        deliveryDate: '',
        isAssineed: '',
        qaName: ''
    }),
    methods: {
        updateData(order){
            let localOrderData = this.$store.getters['app/orderDetails']
            if(localOrderData){
                order = localOrderData
            }
            this.orderData = order;
            let qAssureance = !_.isEmpty(this.orderData.quality_assurance) ? this.orderData.quality_assurance : false;
            if(qAssureance){
                this.qaName = !_.isEmpty(qAssureance.assignee) ? qAssureance.assignee.name : '';
            }
            let submission = !_.isEmpty(this.orderData.submission) ? this.orderData.submission : false;
            if(submission){
                this.traineeId = submission.trainee_id;
                this.dManId = submission.delivery_man_id;
                this.traineeName = !_.isEmpty(submission.trainee) ? submission.trainee.name : '';
                this.dManName = !_.isEmpty(submission.delivery_man) ? submission.delivery_man.name : '';
                this.isAssineed = submission.is_trainee_signed;
                this.deliveryDate = submission.delivery_date.split(" ")[0];
                this.isEditable = false
            } else {
                this.isEditable = true
            }
        },
        saveAssigneeData() {
            this.$refs.submissionForm.validate().then((status) => {
                if(status) {
                    const data = {
                        'trainee_id': this.traineeId,
                        'delivery_man_id': this.dManId,
                        'delivery_date': this.deliveryDate,
                        'is_trainee_signed': this.isAssineed,
                    }
                    this.$boston.post('submission-create/'+ this.orderData.id, data, { headers: {
                            'Content-Type': 'multipart/form-data'
                        }}).then(res => {
                            if (res.error == false) {
                                this.orderData = res.data;
                                this.$root.$emit('wk_update', this.orderData);
                                this.$root.$emit('wk_flow_menu', this.orderData);
                                this.updateData(res.data);
                            }
                            this.$root.$emit('wk_flow_toast', res);
                    }).catch(err => {

                    });
                }
            })
        },
    },
    created() {
        this.updateData(this.order);

    },
}
</script>
