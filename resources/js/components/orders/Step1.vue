<template>
  <div>
    <ValidationObserver ref="orderForm">
      <div class="row mgb-32">
        <div class="col-md-8 ">
          <div class="form-box">
            <h4 class="box-header mb-3">Appraisal details</h4>
            <div class="d-flex justify-content-between w-100">
              <div class="left max-w-424 w-100 me-3">

                <ValidationProvider name="Order no" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Client order no <span class="text-danger require"></span></label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.clientOrderNo">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Loan no" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Loan no</label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.loanNo">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>


                <ValidationProvider name="Received date" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                      <label for="" class="d-block mb-2 dashboard-label">Received date <span
                          class="text-danger require"></span></label>
                      <div class="position-relative">
                        <input type="date" class="dashboard-input w-100" v-model="step1.receiveDate">
                        <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span><span class="path4"></span><span class="path5"></span><span
                            class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                      </div>
                      <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Due date" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Due date <span
                        class="text-danger require"></span></label>
                    <div class="position-relative">
                      <input type="date" class="dashboard-input w-100" v-model="step1.dueDate">
                      <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                          class="path3"></span><span class="path4"></span><span class="path5"></span><span
                          class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                    </div>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
              </div>
              <div class="right max-w-424 w-100">

                <ValidationProvider name="System order" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">System order </label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.systemOrder" readonly>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Loan type" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Loan type </label>
                    <div class="position-relative">
                      <select name="" id="" class="dashboard-input w-100" v-model="step1.loanType">
                        <option value="">Please Select Loan Type</option>
                        <option v-for="loan_type in loanTypes" :key="loan_type.id" :value="loan_type.id">
                          {{ loan_type.name }}
                        </option>
                      </select>
                      <span class="icon-arrow-down bottom-arrow-icon"></span>
                    </div>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="FHA case no" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">FHA case no <span
                        class="text-danger require" v-if="step1.loanType"></span></label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.fhaCaseNo">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Appraiser name" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                        class="text-danger require"></span></label>
                    <div class="position-relative">
                      <select name="" id="" class="dashboard-input w-100" v-model="step1.appraiserName">
                        <option value="">Please select appraisal user name</option>
                        <option v-for="appraisal_user in appraisalUsers" :key="appraisal_user.id"
                                :value="appraisal_user.id">
                          {{ appraisal_user.name }}
                        </option>
                      </select>
                      <span class="icon-arrow-down bottom-arrow-icon"></span>
                    </div>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-box h-100 d-flex flex-column">
            <div>
              <h4 class="box-header mb-3">Provided services</h4>
              <div class="row">
                <div class="col-6">
                  <div class="group" :class="{ 'invalid-form': providerTypes.error.type == true }">
                    <label for="" class="d-block mb-2 dashboard-label">Appraiser type </label>
                    <div class="position-relative">
                       <select name="" id="" class="dashboard-input w-100" @change="checkProviderValidation($event, 1)" v-model="providerTypes.default.type">
                        <option value="">Please select appraisal type</option>
                        <option v-for="appraisal_type in appraisalTypes" :key="appraisal_type.id" :value="appraisal_type.id">
                          {{ appraisal_type.form_type }}
                        </option>
                      </select>
                      <span class="icon-arrow-down bottom-arrow-icon"></span>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="group" :class="{ 'invalid-form': providerTypes.error.fee == true }">
                    <label for="" class="d-block mb-2 dashboard-label">Fee </label>
                    <input type="number" step="any" @input="checkProviderValidation($event, 2)" class="dashboard-input w-100" v-model="providerTypes.default.fee">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 text-end mt-4">
                  <button class="add-more" @click="addFee">
                    <span class="icon-plus"></span> Add more
                  </button>
                  <br><br>
                  <div class="provider-items" v-for="providerType, pi in providerTypes.extra" :key="pi">
                      <span>
                        Type: <strong>{{ providerType.type }}</strong>
                        Fee: <strong>$ {{ providerType.fee }}</strong>
                      </span> 
                      <span>
                          <button class="btn-sm btn-danger" @click="remoteProviderType(providerType, pi)">Remove</button>
                      </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-auto">
              <label for="" class="d-block mb-2 dashboard-label">Note <span class="text-danger require"></span></label>
              <textarea name="" id="" rows="7" class="dashboard-textarea w-100" v-model="step1.note"></textarea>
              <h3 class="text-light-black fw-bold mgt-40">Total fee : <span> $ {{ providerTypes.totalAmount }} </span></h3>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-box h-100">
            <h4 class="box-header mb-3">Client info</h4>
            
            <ValidationProvider name="AMC name" rules="required" v-slot="{ errors }">
              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">AMC name <span
                    class="text-danger require"></span></label>
                <div class="position-relative">
                  <select name="" id="" class="dashboard-input w-100" v-model="step1.amcClient">
                    <option value="">Please select amc client</option>
                    <option v-for="amc_client in amcClients" :key="amc_client.id" :value="amc_client.id">
                      {{ amc_client.name }}
                    </option>
                  </select>
                  <span class="icon-arrow-down bottom-arrow-icon"></span>
                </div>
                <span class="error-message">{{ errors[0] }}</span>
              </div>
            </ValidationProvider>

            <ValidationProvider name="Technology fee" :rules=" { required: (step1.amcClient == '') ? false : true}" v-slot="{ errors }">
              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Technology fee <span
                    class="text-danger require"></span></label>
                <input readonly type="text" class="dashboard-input w-100" v-model="step1.technologyFee">
                <span class="error-message">{{ errors[0] }}</span>
              </div>
            </ValidationProvider>

            <ValidationProvider name="Lender" rules="required" v-slot="{ errors }">
              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Lender <span class="text-danger require"></span></label>
                <div class="position-relative">
                  <select name="" id="" class="dashboard-input w-100" v-model="step1.lender">
                    <option value="">Please select lender client</option>
                    <option v-for="lender_client in lenderClients" :key="lender_client.id" :value="lender_client.id">
                      {{ lender_client.name }}
                    </option>
                  </select>
                  <span class="icon-arrow-down bottom-arrow-icon"></span>
                </div>
                <span class="error-message">{{ errors[0] }}</span>
              </div>
            </ValidationProvider>
          </div>

        </div>
        <div class="col-md-8 ">
          <div class="form-box">
            <h4 class="box-header mb-3">Property info</h4>
            <div class="d-flex justify-content-between w-100">
              <div class="left max-w-424 w-100 me-3">
                <ValidationProvider name="Search address" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Search address <span
                        class="text-danger require"></span></label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.searchAddress">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="State name" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">State name <span class="text-danger require"></span>
                  </label>
                  <input type="text" class="dashboard-input w-100" v-model="step1.state">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="City name" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label label for="" class="d-block mb-2 dashboard-label">City name <span class="text-danger require"></span></label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.city">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Unit No" :rules="{'required' : condoType == true}" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Unit No <span class="text-danger require"></span>
                    </label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.unitNo">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
              </div>

              <div class="right max-w-424 w-100">
                <ValidationProvider name="Street name" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">Street name <span class="text-danger require"></span>
                  </label>
                  <input type="text" class="dashboard-input w-100" v-model="step1.street">
                  <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Zip code" rules="required|integer" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">Zipcode <span class="text-danger require"></span>
                  </label>
                  <input type="number" class="dashboard-input w-100" v-model="step1.zipcode">
                  <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="County" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">County <span class="text-danger require"></span>
                    </label>
                    <input type="text" class="dashboard-input w-100" v-model="step1.country">
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add-client__bottom d-flex justify-content-end  p-3">
        <button class="button button-discard me-3 d-flex align-items-center">Discard <span class="icon-close-circle ms-3"><span
            class="path1"></span><span class="path2"></span></span></button>
        <button class="button button-primary" @click="nextStep">
          Next
          <svg class="ms-4" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M12.4291 13.82C12.2391 13.82 12.0491 13.75 11.8991 13.6C11.6091 13.31 11.6091 12.83 11.8991 12.54L17.4391 7L11.8991 1.46C11.6091 1.17 11.6091 0.689995 11.8991 0.399995C12.1891 0.109995 12.6691 0.109995 12.9591 0.399995L19.0291 6.47C19.3191 6.76 19.3191 7.24 19.0291 7.52999L12.9591 13.6C12.8091 13.75 12.6191 13.82 12.4291 13.82Z"
                fill="white"/>
            <path
                d="M18.33 7.75H1.5C1.09 7.75 0.75 7.41 0.75 7C0.75 6.59 1.09 6.25 1.5 6.25H18.33C18.74 6.25 19.08 6.59 19.08 7C19.08 7.41 18.74 7.75 18.33 7.75Z"
                fill="white"/>
          </svg>
        </button>
      </div>
    </ValidationObserver>
  </div>
</template>

<script>
export default {
  name: "Step1",
  props: {
    systemOrderNo: String,
    orderListUrl: String,
    appraisalUsers: [],
    appraisalTypes: [],
    loanTypes: [],
    amcClients: [],
    lenderClients: [],

  },
  data() {
    return {
      stepActive: false,
      step1: {
        unitNo: '',
        clientOrderNo: '',
        systemOrder: '',
        loanNo: '',
        loanType: '',
        receiveDate: '',
        technologyFee: '',
        fhaCaseNo: '',
        appraiserName: '',
        dueDate: '',
        appraiserType: '',
        amcClient: '',
        lender: '',
        fee: [],
        note: '',
        searchAddress: '',
        state: '',
        city: '',
        street: null,
        zipcode: null,
        country: null,
      },
      //All Msg Property
      clientOrderErrorMsg: '',
      fahCaseNoErrorMsg: '',
      condoType: false,
      providerTypes: {
          default: {
              type: null,
              fee: null,
          },
          error: {
            type: false,
            fee: false
          },
          extra: [],
          totalAmount: 0
      },
    }
  },
  created() {
    this.systemOrder = this.systemOrderNo;
  },
  methods: {
    stepChangeActive() {
      this.$emit('step-change-active', {
        status: this.stepActive,
        data: this.step1
      });
    },

    nextStep() {
      // this.$refs.orderForm.validate().then( (response) => {
         
      // });

      this.stepActive = true;
      this.stepChangeActive();
    },
    validateData() {
      let errorCount = 0;
      if (this.clientOrderNo.length === 0) {
        errorCount++;
        this.clientOrderErrorMsg = 'Client Order No Required';
      }
      return ! errorCount >= 0;
    },
    resetAllErrorMsg() {
      this.clientOrderErrorMsg = '';
      this.fahCaseNoErrorMsg = '';
    },
    addFee() {
        let newType = this.providerTypes.default.type;
        let newFee = this.providerTypes.default.fee;        
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
            let checkOld = ( this.providerTypes.extra ).find((ele) =>  ele.typeId == newType);
            if (!checkOld) {              
              this.providerTypes.extra.push({
                  typeId: appType.id,
                  type: appType.form_type,
                  fee: newFee
              });
            }

            this.providerTypes.default.type = null;
            this.providerTypes.default.fee = null;
            this.providerTypes.error.type = false;
            this.providerTypes.error.fee = false;

            this.checkProviderBalance();
        } else {
            if (this.providerTypes.default.type == null){
                this.providerTypes.error.type = true;
            }
            if (this.providerTypes.default.fee == null){
                this.providerTypes.error.fee = true;
            }
        }
    },

    checkProviderBalance() {
          let totalfee = 0;
          let checkCondoType = false;
          this.providerTypes.extra.map((ele) => {
              totalfee += parseFloat(ele.fee);
              let checkCondo = Object.values(this.appraisalTypes).find(eles => eles.id == ele.typeId);
              if ( checkCondo && checkCondo.condo_type == 1 ) {
                  checkCondoType = true;
              }
          });
          this.providerTypes.totalAmount = totalfee;
          this.condoType = checkCondoType;
    },

    checkProviderValidation(event, type) {
        if (type == 2 && this.providerTypes.default.type == null){
            this.providerTypes.error.type = true;
        } else {
            this.providerTypes.error.type = false;
        }
        if (type == 1 && this.providerTypes.default.fee == null){
            this.providerTypes.error.fee = true;
        } else {
            this.providerTypes.error.fee = false;
        }
    },
    remoteProviderType(item, index) {
        this.providerTypes.extra.splice(index, 1);
        if (this.providerTypes.extra.length == 0) {
            this.providerTypes.totalAmount = 0;
            this.condoType = false;
        } else {
          this.checkProviderBalance();
        }
    }
  },
  watch: {
    providerTypes: {
      handler(val) {
          // this.checkProviderValidation(val);
      },
      deep:true
    },
    step1: {
      handler(val) {
        this.$root.$emit("updateStepData", {
          step: 1,
          data: val
        });
      },
      deep: true
    }
  }
}
</script>

<style scoped>
.provider-items {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    text-align: left;
    font-size: 13px;
    vertical-align: middle;
    align-items: center;
    border-bottom: thin solid #999;
    padding-bottom: 15px;
}
.provider-items span strong {
  display: block;
}
.provider-items:nth-last-child(1) {
  border-bottom: none;
}
</style>
