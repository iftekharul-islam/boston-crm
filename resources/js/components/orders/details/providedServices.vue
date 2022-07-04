<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Provided Services</p>
      <a v-b-modal.provided-services class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list_groups" v-for="item, ik in servicesData" :key="ik">
        <p class="mb-0 left-side">Appraiser type: <strong class="primary-text">{{ item.type }}</strong></p>
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
                    <div class="d-flex provided-service align-items-center" v-for="item, ik in servicesData" :key="ik">
                      <div class="group mgr-32">
                        <div class="pr-2">
                          <label for="" class="d-block dashboard-label mb-2">Appraiser type <span class="require"></span></label>
                          <m-select v-model="item.typeId" :options="appraisalTypes" item-value="id" item-text="form_type" object></m-select>
                        </div>
                      </div>
                      <div class="group">
                        <label for="" class="d-block dashboard-label mb-2">Appraisal fee <span class="require"></span></label>
                        <input type="text" v-model="item.fee" class="dashboard-input w-100">
                      </div>
                      <div class="right-btn ms-auto">
                        <button class="button button-transparent p-0" @click="remoteProviderType(item, ik)">
                          <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        </button>
                      </div>
                    </div>
                    <div class="d-flex mb-0 provided-service" v-if="servicesData.length < appraisalTypes.length">
                      <div class="group mb-0 mgr-32">
                        <div class="pr-2">
                          <label for="" class="d-block mb-2 dashboard-label">Appraiser Type <span class="require"></span></label>
                          <m-select v-model="add.serviceType" @change="addNewMod" :options="appraisalTypes" item-value="id" item-text="form_type" object></m-select>
                        </div>
                      </div>
                      <div class="group mb-0">
                        <label for="" class="d-block mb-2 dashboard-label">Appraisal fee <span class="require"></span></label>
                        <input type="text" @blur="addNewMod" v-model="add.serviceFee" class="dashboard-input w-100">
                      </div>
                    </div>
                    <div class="d-flex mgb-32 mgt-12" v-if="servicesData.length < appraisalTypes.length">
                      <button class="button button-transparent p-0 text-400" @click="addNewMod"><span class="icon-plus"></span> Add more</button>
                    </div>
                </ValidationObserver>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Note</label>
                <textarea type="text" v-model="note" class="dashboard-input w-100" style="min-height: 100px"></textarea>
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
        orderData: [],
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
          this.orderData = this.order;
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
            this.$toast.open({
                message: res.message,
                type: res.error == true ? 'error' : 'success',
            });
            if (res.error == false) {
                this.orderData = res.order;
                this.$emit('updateSection', {section: 'providedService', data: this.orderData});
                this.$bvModal.hide('provided-services');
                this.checkProviderBalance();  
                this.$root.$emit("wk_update", this.orderData);
            }
        })
        .catch( err =>{
        })
      },
      addNewMod() {
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
              this.checkProviderBalance();
              this.add.serviceType = null;
              this.add.serviceFee = null;
              this.$refs.orderForm.reset();
          }
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
          this.add.serviceType = null;
          this.add.serviceFee = null;
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
.provided-service .group {
  /* flex: 0 40%; */
}
.provided-service .group:nth-child(1) {
  flex-basis: 196px;
  padding-right: 10px;
}
.provided-service .group:nth-child(2) {
  padding-right: 10px;
  flex-basis: 168px;
}
</style>
