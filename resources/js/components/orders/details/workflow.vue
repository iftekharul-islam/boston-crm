<template>
  <div class="order-details__left col-md-8">
    <!-- Workflow -->
    <div class="order-details-box bg-white h-100">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Workflow</p>
        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span
            class="path1"></span><span class="path2"></span></span></a>
      </div>
      <div class="box-body">
        <div class="workflow-content">
          <!--          step list-->
          <div class="list">
            <div class="item" :class="{'complete' : status.orderCreate === 1}" @click="changeTab('order-create')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item" :class="{'complete' : status.scheduling === 1,'current' : (status.scheduling !== 1 && status.orderCreate === 1 )}" @click="changeTab('scheduling')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Scheduling</p>
            </div>
            <div class="item" :class="{'complete' : status.inspection === 1,'current' : (status.inspection !== 1 && status.scheduling === 1 )}" @click="changeTab('inspection')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Inspection</p>
            </div>
            <div class="item" :class="{'complete' : status.reportPreparation === 1,'current' : (status.reportPreparation !== 1 && status.inspection === 1 )}" @click="changeTab('report-preparation')">
                <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Report Preparation</p>
            </div>
            <div class="item" :class="{'complete' : status.initialReview === 1,'current' : (status.initialReview !== 1 && status.reportPreparation === 1 )}" @click="changeTab('initial-review')">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Initial Review</p>
            </div>
            <div class="item" :class="{'complete' : status.reportAnalysisReview === 1,'current' : (status.reportAnalysisReview !== 1 && status.initialReview === 1 )}" @click="changeTab('report-analysis-review')">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Report Analysis and Review</p>
            </div>
            <div class="item" :class="{'complete' : status.reWritingReport === 1,'current' : (status.reWritingReport !== 1 && status.reportAnalysisReview === 1 )}" @click="changeTab('rewriting-report')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Re-writing the report</p>
            </div>
            <div class="item" :class="{'complete' : status.qualityAssurance === 1,'current' : (status.qualityAssurance !== 1 && status.reWritingReport === 1 )}" @click="changeTab('quality-assurance')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Quality Assurance (E&O)</p>
            </div>
            <div class="item" :class="{'complete' : status.submission === 1,'current' : (status.submission !== 1 && status.qualityAssurance === 1 )}" @click="changeTab('submission')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Submission</p>
            </div>
            <div class="item" :class="{'complete' : status.revision === 1,'current' : (status.revision !== 1 && status.submission === 1 )}" @click="changeTab('revision')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Revision</p>
            </div>
          </div>
          <!-- step item -->
          <div class="step-item ">
            <!-- Order creation -->
            <OrderCreate :order="this.order" v-if="isActive === 'order-create'"></OrderCreate>
            <!-- Scheduling -->
            <Schedule :order="this.order" v-if="isActive === 'scheduling'"></Schedule>
            <!-- Inspection -->
            <Inspection v-if="isActive === 'inspection'"></Inspection>
            <!-- Report preparation -->
            <ReportPreparation v-if="isActive === 'report-preparation'"></ReportPreparation>
            <!-- Initial Review -->
            <InitialReview v-if="isActive === 'initial-review'"></InitialReview>
            <!-- Report Analysis and Review -->
            <ReportAnalysisReview v-if="isActive === 'report-analysis-review'"></ReportAnalysisReview>
            <!-- Re-writing the report -->
            <RewritingReport v-if="isActive === 'rewriting-report'"></RewritingReport>
            <!-- Quality Assurance (E&O) -->
            <QualityAssurance v-if="isActive === 'quality-assurance'"></QualityAssurance>
            <!-- Submission -->
            <Submission v-if="isActive === 'submission'"></Submission>
            <!-- Revision -->
            <Revision v-if="isActive === 'revision'"></Revision>
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

export default {
  name: 'WorkFlow',
  props: {
    order: []
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
  data: () => ({
    isActive: 'order-create',
    status: [],
  }),
  created(){
    this.status = this.order.workflow_status ?? [];
  },
  methods: {
    changeTab(type) {
      this.isActive = type
    }
  }
}
</script>
