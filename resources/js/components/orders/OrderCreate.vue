<template>
  <div class="order-add bg-platinum dashboard-space">
    <div class="order-add-box bg-white">
      <div class="order-add-box__form">
        <div class="d-flex align-items-center justify-content-between">
          <p class="fw-bold">Add new order</p>
          <div class="step">
            <button @click="gotoStep(1)" class="step-btn pointer"
                    :class="{'active': step === 1}">Step 1</button>
            <button @click="gotoStep(2)" class="step-btn" :class="{'active': step === 2}">Step 2</button>
          </div>
        </div>
        <div class="alert alert-danger alertBlocks" v-if="submitResult.error">
            <template v-for="eItem in submitResult.message">
              <span v-for="erItem, ei in eItem" :key="ei">
                * {{ erItem }}
              </span>
            </template>
        </div>
        <div class="alert alert-success" v-if="submitResult.submitStatus">
            {{ submitResult.message }}
        </div>
        <Step1 v-show="step === 1"
               @step-change-active="stepChangeActiveStatus"
               :order-list-url="orderList"
               :system-order-no="systemOrderNo"
               :appraisal-users="appraisalUsers"
               :appraisal-types="appraisalTypes"
               :loan-types="loanTypes"
               :amc-clients="amcClients"
               :lender-clients="lenderClients"/>
        <Step2 v-show="step === 2"/>
      </div>
    </div>
  </div>
</template>

<script>
import Step1 from './Step1';
import Step2 from './Step2';

export default {
  name: "OrderCreate",
  props: {
    orderList: String,
    systemOrderNo: String,
    appraisalUsers: [],
    appraisalTypes: [],
    loanTypes: [],
    company: [],
    amcClients: [],
    lenderClients: [],
    user_id: null
  },
  components: {
    Step1,
    Step2,
  },
  data() {
    return {
      step: 1,
      stepChangeActive: false,
      step1Data: [],
      step2Data: [],
      submitResult: {
          error: false,
          submitStatus: false,
          message: []
      }
    }
  },
  created() {
      this.$root.$on("updateStepData", (res) => {
          if (res.step == 1) {
            this.step1Data = res.data;
          } else {
            this.step2Data = res.data;
          }
      });
      
      this.$root.$on("submitOrder", (res) => {
          this.$boston.apiPost('store/order', {'step1' : this.step1Data, 'step2' : this.step2Data, 'company': this.company, 'user_id': this.user_id }).then(res => {
              this.submitResult.error = res.error;
              this.submitResult.submitStatus = false;
              this.submitResult.message = res.messages;

              if (res.error == false) {
                this.submitResult.message = res.message;
                this.submitResult.submitStatus = true;
                this.$root.$emit('orderSubmitConfirm', true);
                this.stepChangeActive = false;
                this.step = 1;
              }
          });
      });
  },
  methods: {
    stepChangeActiveStatus(value) {
      this.stepChangeActive = value.status;
      this.step1Data = value.data;
      if (value.status == true) {
          this.changeStep(2);
      } else {
          this.changeStep(1);
      }
    },
    changeStep(step) {
      if (step === 1) {
        this.step = 1;
      }
      if (step === 2 && this.stepChangeActive) {
        this.step = 2;
      }
    },
    orderListView() {
      window.location.href = this.orderList
    },
    gotoStep(step) {
        this.changeStep(step);
    }
  }

}
</script>

<style scoped>
.alertBlocks span{
    display: block;
    margin-bottom: 5px;
}
</style>
