<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Provided Services</p>
      <a v-b-modal.provided-services class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list_groups" v-for="item, ik in servicesData" :key="ik">
        <p class="mb-0 left-side">Appraiser Type: <strong class="primary-text">{{ item.type }}</strong></p>
        <p class="right-side mb-0">Fee: <strong class="primary-text">${{ item.fee }}</strong></p>
      </div>
      <hr>
      <div class="list_groups">
        <p class="mb-0 left-side">Total Fee: <strong class="text-success">${{ servicesFee }}</strong></p>
      </div>
      <div class="text-left">
        <strong>Note</strong>
        <div>
          {{ note }}
        </div>
      </div>
    </div>
    <!-- modal -->
      <b-modal id="provided-services" size="md" title="Edit Provided Services">
          <div class="modal-body">
            <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
            <div class="row">
              <div class="col-md-12">
                
                <ValidationObserver class="" ref="orderForm">
                    <div class="d-flex mgb-32">
                      <ValidationProvider class="mgr-32 flex-1" name="Appraiser Type" rules="required" v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                          <label for="" class="d-block mb-2 dashboard-label">Appraiser Type <span class="require"></span></label>
                          <div class="position-relative">
                              <b-form-select
                                v-model="add.serviceType"
                                :options="appraisalTypes"
                                value-field="id"
                                text-field="form_type"
                                class="dashboard-input w-100">
                              <template #first>
                                <b-form-select-option value="" disabled>Please select an option</b-form-select-option>
                              </template>
                            </b-form-select>
                            <span class="icon-arrow-down bottom-arrow-icon"></span>
                          </div>
                          <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                      </ValidationProvider>
                      <ValidationProvider class="flex-1" name="Appraisal Fee" rules="required" v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                          <label for="" class="d-block mb-2 dashboard-label">Appraisal Fee <span class="require"></span></label>
                          <input type="text" v-model="add.serviceFee" class="dashboard-input w-100">
                          <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                      </ValidationProvider>
                    </div>
                    <!-- appraiser name -->
                    <div class="d-flex mgb-32">
                      <div class="mgr-32 flex-1">
                          <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span class="require"></span></label>
                          <div class="position-relative">
                            <select name="" id="" class="dashboard-input w-100">
                              <option value="">fdgfd</option>
                            </select>
                             <span class="icon-arrow-down bottom-arrow-icon"></span>
                          </div>
                      </div>
                      <div class="flex-1">
                        <label for="" class="d-block mb-2 dashboard-label">Appraiser Fee <span class="require"></span></label>
                        <input type="text" class="dashboard-input w-100">
                      </div>

                    </div>

                    <div class="d-flex mgb-32">
                      <button class="button button-transparent p-0" @click="addNewMod"><span class="icon-plus"></span> Add more</button>
                    </div>
                </ValidationObserver>
              </div>
              <ValidationProvider class="" name="Note" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Note <span class="require"></span></label>
                    <textarea type="text" v-model="note" class="dashboard-input w-100" style="min-height: 100px"></textarea>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

              <!-- <div class="divider"></div> -->
               <div class="list_groups" v-for="item, ik in servicesData" :key="ik">
                <div class="left-side">
                  <p class="mb-0">Appraiser Type:</p>
                  <p class="mb-0"><strong class="primary-text">{{ item.type }}</strong></p>
                </div>
                <div class="left-side">
                  <p class="mb-0"> Fee:</p>
                  <p class="mb-0"><strong class="primary-text">${{ item.fee }}</strong></p>
                </div>
                <p class="right-side mb-0">
                  <button class="button button-primry p-1" @click="remoteProviderType(item, ik)">
                    <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                  </button>
                </p>
              </div>
            </div>
          </div> 
        <div slot="modal-footer" class="mgt-44">
          <b-button variant="secondary" @click="$bvModal.hide('provided-services')">Close</b-button>
          <b-button variant="primary" @click="updateProvidedServices">Save</b-button>
        </div>
      </b-modal>
  </div>
</template>
<script>
  export default {
    props:{
      orderId: String,
      order:[],
      appraisalTypes: []
    },
    data(){
      return{
        services: [],
        servicesData: [],
        servicesFee: null,
        note: null,
        message: '',
        unitNo: null,
        add: {
          serviceType: null,
          serviceFee: null,
        }
      }
    },
    created() {
      this.getProvidedServices()
    },
    methods:{
      getProvidedServices(){
          this.services = this.order.provider_service;
          this.servicesData = JSON.parse(this.services.appraiser_type_fee);
          this.servicesFee = this.order.provider_service.total_fee;
          this.note = this.order.provider_service.note;
      },
      updateProvidedServices() {
        this.$boston.post('order/update/providerService', {
            fee: this.servicesFee, 
            data: this.servicesData, 
            note: this.note,
            order: this.order
        }).then( res => {
            this.message = res.messages;
            setTimeout(function(){
              this.$bvModal.hide('provided-services')
              this.message = ''
            }.bind(this), 2000);
        })
        .catch( err =>{
        })
      },
      addNewMod() {
          this.$refs.orderForm.validate().then(status => {
            let newType = this.add.serviceType;
            let newFee = this.add.serviceFee;
            if (newType && newFee) {
                let appType = [];
                for (let i in this.appraisalTypes) {
                    let appritem = this.appraisalTypes[i];
                    if (appritem.id == newType) {
                        appType = appritem;
                    }
                }
                if ( appType.condo_type == 1) {
                  this.condoType = true;
                }
                let checkOld = ( this.servicesData ).find((ele) =>  ele.typeId == newType);
                if (!checkOld) {              
                  this.servicesData.push({
                      typeId: appType.id,
                      type: appType.form_type,
                      fee: newFee
                  });
                }
                this.add.serviceType = null;
                this.add.serviceFee = null;
                this.checkProviderBalance();
                this.$refs.orderForm.reset();
            }
          });
      },
      remoteProviderType(item, index) {
        this.servicesData.splice(index, 1);
        this.checkProviderBalance();
      },
      checkProviderBalance() {
          let totalfee = 0;
          this.servicesData.map((ele) => {
              totalfee += parseFloat(ele.fee);
          });
          this.servicesFee = totalfee;
      },
    }
  }
</script>

<style scoped>
.list_groups{
  display: flex;
  justify-content: space-between;
  margin-bottom: 5px;
  padding-bottom: 5px;
}
.list_groups:nth-last-child(1){
  margin-bottom: 0px;
  padding-bottom: 0px;
}
.divider {
    border-top: 4px solid #35a6dc;
    background: transparent;
    padding-top: 20px;
    margin-top: 20px;
}
</style>
