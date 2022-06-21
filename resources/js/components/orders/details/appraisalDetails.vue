<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Appraisal Details</p>
      <a v-b-modal.appraisal-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span
          class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Appraiser Name</p>
        <span>:</span>
        <p class="right-side mb-0">{{ edited.appraiser_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Loan #</p>
        <span>:</span>
        <p class="right-side mb-0 word-break">{{ edited.loan_no }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Loan Type </p>
        <span>:</span>
        <p class="right-side mb-0">{{ edited.loan_type_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">FHA Case</p>
        <span>:</span>
        <p class="right-side mb-0 word-break">{{ edited.fha_case_no }}</p>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="appraisal-info" size="lg" title="Edit appraisal Information">
      <div class="modal-body">
        <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
        <div class="row">
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Appraiser Name <span class="require"></span></label>
              <b-form-select
                  v-model="details.appraiser_id"
                  :options="this.appraisers"
                  value-field="id"
                  text-field="name"
                  class="dashboard-input w-100">
                <template #first>
                  <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                </template>
              </b-form-select>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Loan Type <span class="require"></span></label>
              <b-form-select
                  v-model="details.loan_type"
                  :options="this.loanTypes"
                  value-field="id"
                  text-field="name"
                  class="dashboard-input w-100">
                <template #first>
                  <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                </template>
              </b-form-select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Loan # <span class="require"></span></label>
              <input type="text" v-model="details.loan_no" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">FHA Case No <span class="require"></span></label>
              <input type="text" v-model="details.fha_case_no" class="dashboard-input w-100">
            </div>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('appraisal-info')">Close</b-button>
        <b-button variant="primary" @click="updateAppraisalDetails">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: {
    orderId: String,
    order: [],
    appraisers: [],
    loanTypes: []
  },
  data() {
    return {
      details: {
        appraiser_name: '',
        appraiser_id: '',
        appraiser_type: '',
        loan_type: '',
        loan_type_name: '',
        loan_no: '',
        fha_case_no: '',
      },
      message: '',
      edited: {}
    }
  },

  created() {
    // this.details = this.order.app
    let providerService = this.order.provider_service;
    let types = JSON.parse(providerService.appraiser_type_fee);
    if (types.length) {
      this.details.appraiser_type = types[0].type;
      this.details.appraiser_type_id = types[0].typeId;
    }
    this.getAppraisalDetails();
  },
  methods: {
    getAppraisalDetails() {
      this.details.appraiser_id = this.order.appraisal_detail.appraiser_id;
      this.details.loan_type = this.order.appraisal_detail.loan_type;
      this.details.appraiser_name = this.order.appraisal_detail.appraiser.name;
      this.details.loan_type_name = this.order.appraisal_detail.get_loan_type.name;
      this.details.loan_no = this.order.appraisal_detail.loan_no;
      this.details.fha_case_no = this.order.appraisal_detail.fha_case_no;
      this.edited = Object.assign({}, this.details);
    },
    updateAppraisalDetails() {
      let that = this
      axios.post('update-appraisal-info/' + this.orderId, this.details)
          .then(res => {
            this.message = res.data.message
            this.edited = Object.assign({}, this.details);
            setTimeout(function () {
              that.$bvModal.hide('appraisal-info')
              that.message = ''
            }, 2000);
          }).catch(err => {
        console.log(err)
      })
    }
  }
}
</script>
