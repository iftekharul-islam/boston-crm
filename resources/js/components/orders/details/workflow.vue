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
            <div class="item complete" @click="changeTab('order-create')">
                <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item complete" @click="changeTab('scheduling')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Scheduling</p>
            </div>
             <div class="item current" @click="changeTab('inspection')">
              <span class="ball"><img src="/img/current-white.png" alt="current step boston"></span>
              <p class="mb-0">Inspection</p>
            </div>
            <div class="item" @click="changeTab('report-preparation')">
                <span class="ball">
                    <img src="/img/current-white.png" alt="current step boston">
                </span>
              <p class="mb-0">Report Preparation</p>
            </div>
            <div class="item" @click="changeTab('initial-review')">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Initial Review</p>
            </div>
            <div class="item" @click="changeTab('report-analysis-review')">
              <span class="ball">
                  <img src="/img/current-white.png" alt="current step boston">
              </span>
              <p class="mb-0">Report Analysis and Review</p>
            </div>
            <div class="item" @click="changeTab('rewriting-report')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Re-writing the report</p>
            </div>
             <div class="item" @click="changeTab('quality-assurance')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Quality Assurance (E&O)</p>
            </div>
             <div class="item" @click="changeTab('submission')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Submission</p>
            </div>
            <div class="item" @click="changeTab('revision')">
                  <span class="ball">
                      <img src="/img/current-white.png" alt="current step boston">
                  </span>
              <p class="mb-0">Revision</p>
            </div>
          </div>
      <!-- step item -->
          <div class="step-item " >
            <!-- Order creation -->
            <OrderCreate v-if="isActive === 'order-create'"></OrderCreate>
            <!-- Scheduling -->
            <Schedule v-if="isActive === 'scheduling'"></Schedule>
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
  props:{
    order: []
  },
  components:{
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
  data:() => ({
    isActive: 'order-create'
  }),
  methods:{
    changeTab(type){
      this.isActive = type
    }
  }
}
</script>
