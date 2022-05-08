<template>
  <div class="order-add bg-platinum dashboard-space">
    <div class="order-add-box bg-white">
      <div class="order-add-box__form">
        <div class="d-flex align-items-center justify-content-between">
          <p>Add new order</p>
          <div class="step">
            <button class="step-btn pointer" :class="{'active': step === 1}" @click="changeStep(1)">Step 1</button>
            <button class="step-btn" :class="{'active': step === 2}" @click="changeStep(2)">Step 2</button>
          </div>
        </div>
        <Step1 v-show="step === 1" :step-change-active="stepChangeActiveStatus"/>
        <Step2 v-show="step === 2"/>
      </div>
      <div class="add-client__bottom d-flex justify-content-end  p-3">
        <button class="button button-discard me-3 d-flex align-items-center" @click="orderListView">Discard <span class="icon-close-circle ms-3"><span class="path1"></span><span class="path2"></span></span></button>
        <button class="button button-primary" v-if="step === 1" @click="changeStep(2)">
          Next
          <svg class="ms-4" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.4291 13.82C12.2391 13.82 12.0491 13.75 11.8991 13.6C11.6091 13.31 11.6091 12.83 11.8991 12.54L17.4391 7L11.8991 1.46C11.6091 1.17 11.6091 0.689995 11.8991 0.399995C12.1891 0.109995 12.6691 0.109995 12.9591 0.399995L19.0291 6.47C19.3191 6.76 19.3191 7.24 19.0291 7.52999L12.9591 13.6C12.8091 13.75 12.6191 13.82 12.4291 13.82Z" fill="white"/>
            <path d="M18.33 7.75H1.5C1.09 7.75 0.75 7.41 0.75 7C0.75 6.59 1.09 6.25 1.5 6.25H18.33C18.74 6.25 19.08 6.59 19.08 7C19.08 7.41 18.74 7.75 18.33 7.75Z" fill="white"/>
          </svg>
        </button>
        <button class="button button-primary" v-if="step === 2"> Add order </button>
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
