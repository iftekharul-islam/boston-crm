<template>
  <div class="order-add bg-platinum dashboard-space">
    <div class="order-add-box bg-white">
      <div class="order-add-box__form">
        <div class="d-flex align-items-center justify-content-between">
          <p class="fw-bold">Add new order</p>
          <div class="step">
            <button class="step-btn pointer"
                    :class="{'active': step === 1}">Step 1</button>
            <button class="step-btn" :class="{'active': step === 2}">Step 2</button>
          </div>
        </div>
        <Step1 v-show="step === 1"
               :step-change-active="stepChangeActiveStatus"
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
    amcClients: [],
    lenderClients: [],
  },
  components: {
    Step1,
    Step2,
  },
  data() {
    return {
      step: 1,
      stepChangeActive: true,
    }
  },
  created() {
  },
  methods: {
    stepChangeActiveStatus(value) {
      this.stepChangeActive = value;
    },
    changeStep(step) {
      if (step === 1) {
        this.step = step;
      }
      if (step === 2 && this.stepChangeActive) {
        this.step = step;
      }
    },
    orderListView() {
      window.location.href = this.orderList
    }
  }

}
</script>

<style scoped>

</style>
