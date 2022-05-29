<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Appraisal Details</p>
      <a v-b-modal.appraisal-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Appraiser Type</p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.appraiser_type }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Appraiser Name</p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.appraiser_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Client Order #</p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.client_order_no }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Loan #</p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.loan_no }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Loan Type </p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.loan_type_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">FHA Case</p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.fha_case_no }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Appraisal Total Fee </p>
        <span>:</span>
        <p class="right-side mb-0">{{ details.technology_fee }}</p>
      </div>
    </div>
    <!-- modal -->
     <b-modal id="appraisal-info" size="lg" title="Edit appraisal Information">
        <div class="modal-body">
          <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
          <div class="row">
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Appraiser Type <span class="require"></span></label>
                <b-form-select
                    v-model="details.appraiser_type_id"
                    :options="appraiserTypes"
                    value-field="id"
                    text-field="form_type"
                    class="dashboard-input w-100">
                  <template #first>
                    <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                  </template>
                </b-form-select>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Appraiser Name <span class="require"></span></label>
                <b-form-select
                    v-model="details.appraiser_id"
                    :options="appraisers"
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
                    :options="loanTypes"
                    value-field="id"
                    text-field="name"
                    class="dashboard-input w-100">
                  <template #first>
                    <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                  </template>
                </b-form-select>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Appraisal Fee <span class="require"></span></label>
                <input type="text" v-model="details.technology_fee" class="dashboard-input w-100">
              </div>
            </div>
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Client Order # <span class="require"></span></label>
                <input type="text" v-model="details.client_order_no" class="dashboard-input w-100">
              </div>
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
    props:{
      orderId: String
    },
    data(){
      return{
        details:{
          appraiser_id: '',
          appraiser_name: '',
          appraiser_type_id: '',
          appraiser_type: '',
          loan_type: '',
          loan_type_name: '',
          client_order_no: '',
          system_order_no: '',
          loan_no: '',
          fha_case_no: '',
          due_date: new Date(),
          received_date: new Date(),
          technology_fee: ''
        },
        appraiserTypes: '',
        appraisers: '',
        loanTypes: '',
        message: ''
      }
    },
    mounted() {
      this.getAppraisalDetails()
    },
    methods:{
      getAppraisalDetails(){
        let that = this
        axios.get('get-appraisal-info/'+this.orderId)
            .then(res => {
              console.log('data'+res.data.orderDetails)
              that.details.appraiser_name = res.data.appraisalDetails.appraiser.name
              that.details.loan_type_name = res.data.appraisalDetails.loantype.name

              that.details.client_order_no = res.data.orderDetails.client_order_no
              that.details.appraiser_id = res.data.appraisalDetails.appraiser_id
              that.details.loan_type = res.data.appraisalDetails.loan_type
              that.details.system_order_no = res.data.orderDetails.system_order_no
              that.details.loan_no = res.data.appraisalDetails.loan_no
              that.details.fha_case_no = res.data.appraisalDetails.fha_case_no
              that.details.due_date = res.data.appraisalDetails.due_date
              that.details.received_date = res.data.appraisalDetails.received_date
              that.details.technology_fee = res.data.appraisalDetails.technology_fee

              that.appraiserTypes = res.data.appraiserTypes
              that.appraisers = res.data.appraisers
              that.loanTypes = res.data.loanTypes
            }).catch(err => {
          console.log(err)
        })
      },
      updateAppraisalDetails() {
        let that = this
        axios.post('update-appraisal-info/' + that.orderId,that.details)
            .then( res => {
              that.message = res.data.message
              setTimeout(function(){
                that.$bvModal.hide('basic-info')
              }, 2000);
            }).catch( err =>{
              console.log(err)
        })
      }
    }
  }
</script>
