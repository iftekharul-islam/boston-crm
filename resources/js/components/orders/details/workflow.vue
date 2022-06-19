<template>
  <div class="order-details__left col-md-8">
    <!-- Workflow -->
    <div class="order-details-box bg-white h-100">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Workflow</p>
      </div>
      <div class="box-body">
        <div class="workflow-content">
          <!--          step list-->
          <div class="list">
            <div class="item" :class="{'complete' : status.orderCreate === 1}" @click="changeTab('order-create')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item" :class="{'complete' : status.scheduling === 1,'current' : (status.scheduling !== 1 && status.orderCreate === 1 ), 'activeStep' : isActive == 'scheduling' }" @click="changeTab('scheduling')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Scheduling</p>
            </div>
            <div class="item" :class="{'complete' : status.inspection === 1,'current' : (status.inspection !== 1 && status.scheduling === 1 ), 'activeStep' : isActive == 'inspection'}" @click="changeTab('inspection')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Inspection</p>
            </div>
            <div class="item" :class="{'complete' : status.reportPreparation === 1,'current' : (status.reportPreparation !== 1 && status.inspection === 1 ), 'activeStep' : isActive == 'report-preparation'}" @click="changeTab('report-preparation')">
                <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Report Preparation</p>
            </div>
            <div class="item" :class="{'complete' : status.initialReview === 1, 'current' : (status.initialReview !== 1 && status.reportPreparation === 1 ), 'activeStep' : isActive == 'initial-review'}" @click="changeTab('initial-review')">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Initial Review</p>
            </div>
            <div class="item" :class="{'complete' : status.reportAnalysisReview === 1, 'current' : (status.reportAnalysisReview !== 1 && status.initialReview === 1 ), 'activeStep' : isActive == 'report-analysis-review'}" @click="changeTab('report-analysis-review')">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Report Analysis and Review</p>
            </div>
            <div class="item" :class="{ 'disable' : norewrite === 1, 'complete' : status.reWritingReport === 1,'current' : (status.reWritingReport !== 1 && status.reportAnalysisReview === 1 ), 'activeStep' : isActive == 'rewriting-report'}" @click="changeTab('rewriting-report', norewrite)">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Re-writing the report</p>
            </div>
            <div class="item" :class="{'complete' : status.qualityAssurance === 1, 'current' : (status.qualityAssurance !== 1 && status.reWritingReport === 1 ), 'activeStep' : isActive == 'quality-assurance'}" @click="changeTab('quality-assurance')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Quality Assurance (E&O)</p>
            </div>
            <div class="item" :class="{'complete' : status.submission === 1,'current' : (status.submission !== 1 && status.qualityAssurance === 1 ), 'activeStep' : isActive == 'submission'}" @click="changeTab('submission')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Submission</p>
            </div>
            <div class="item" :class="{'complete' : status.revision === 1,'current' : (status.revision !== 1 && status.submission === 1 ), 'activeStep' : isActive == 'revision'}" @click="changeTab('revision')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Revision</p>
            </div>
          </div>
          <!-- step item -->
          <div class="step-item ">
            <!-- Order creation -->
            <OrderCreate :order="orderData" v-if="isActive === 'order-create'"></OrderCreate>
            <!-- Scheduling -->
            <Schedule :order="orderData" :appraisers="appraisers" v-if="isActive === 'scheduling'"></Schedule>
            <!-- Inspection -->
            <Inspection :inspection="orderData['inspection']" v-if="isActive === 'inspection'"></Inspection>
            <!-- Report preparation -->
            <ReportPreparation v-if="isActive === 'report-preparation'" :role="myRole" :users="users" :order="orderData"></ReportPreparation>
            <!-- Initial Review -->
            <InitialReview :order="orderData" :users="users" v-if="isActive === 'initial-review'"></InitialReview>
            <!-- Report Analysis and Review -->
            <ReportAnalysisReview v-if="isActive === 'report-analysis-review'" :order="orderData" :users="users"></ReportAnalysisReview>
            <!-- Re-writing the report -->
            <RewritingReport :order="orderData" v-if="isActive === 'rewriting-report'"></RewritingReport>
            <!-- Quality Assurance (E&O) -->
            <QualityAssurance :order="order" :users="users" v-if="isActive === 'quality-assurance'"></QualityAssurance>
            <!-- Submission -->
            <Submission :order="order" :users="users" v-if="isActive === 'submission'"></Submission>
            <!-- Revision -->
            <Revision :order="orderData" v-if="isActive === 'revision'"></Revision>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import OrderCreate from '../workflow/OrderCreate'
import Schedule from '../workflow/Schedule'
import Inspection from '../workflow/Inspection'
import ReportPreparation from "../workflow/ReportPreparation";
import InitialReview from "../workflow/InitialReview";
import ReportAnalysisReview from "../workflow/ReportAnalysisReview";
import RewritingReport from "../workflow/RewritingReport";
import QualityAssurance from "../workflow/QualityAssurance";
import Submission from "../workflow/Submission";
import Revision from "../workflow/Revision";
import { integer } from 'vee-validate/dist/rules';

export default {
  name: 'WorkFlow',
  props: {
    norewrite: integer,
    users: Array,
    permissions: Array,
    role: String,
    order: [],
    appraisers: [],
  },
  components: {
    Revision,
    Submission,
    QualityAssurance,
    RewritingReport,
    ReportAnalysisReview,
    InitialReview,
    ReportPreparation,
    OrderCreate,
    Schedule,
    Inspection
  },
  provide() {
    return {
      usersInfo: this.users,
      appraisersInfo: this.appraisers,
    }
  },
  data: () => ({
    isActive: 'order-create',
    status: '',
    myRole: '',
  }),
  created(){
      this.initOrder(this.order);
      this.updateRole()

      let getParams = this.params();
      if (getParams['wkf']) {
          this.changeTab(getParams['wkf']);
      }

      this.$root.$on('wk_flow_menu', (res) => {
          this.initOrder(res);
      });
  },
  methods: {
    initOrder(order) {
        this.orderData = order;
        this.status = JSON.parse(order.workflow_status) ?? [];
    },
    updateRole() {
      if (this.role.length) {
        this.myRole = this.role
      }
    },
    changeTab(type, value = 0) {
      if (value === 1) {
          return false;
      }
      this.isActive = type;
      if (type == "revision") {
        this.$root.$emit('open_revision', true);
      }
      this.addParam('wkf', type);
    }
  }
}
</script>
