<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Provided Services</p>
      <a v-b-modal.provided-services class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Appraiser Type</p>
        <span>:</span>
        <p class="right-side mb-0">{{ services.appraiser_type }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Appraisal Total Fee </p>
        <span>:</span>
        <p class="right-side mb-0">{{ services.technology_fee }}</p>
      </div>
    </div>
    <!-- modal -->
     <b-modal id="provided-services" size="lg" title="Edit appraisal Information">
        <div class="modal-body">
          <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
          <div class="row">
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Appraiser Type <span class="require"></span></label>
                <b-form-select
                    v-model="services.appraiser_type_id"
                    :options="this.appraisalTypes"
                    value-field="id"
                    text-field="form_type"
                    class="dashboard-input w-100">
                  <template #first>
                    <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                  </template>
                </b-form-select>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Appraisal Fee <span class="require"></span></label>
                <input type="text" v-model="services.technology_fee" class="dashboard-input w-100">
              </div>
            </div>
          </div>
        </div>
      <div slot="modal-footer">
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
        services:{
          appraiser_type: '',
          appraiser_type_id: '',
          technology_fee: ''
        },
        message: ''
      }
    },
    created() {
      this.getProvidedServices()
    },
    methods:{
      getProvidedServices(){
          this.services.appraiser_type = JSON.parse(this.order.provider_service.appraiser_type_fee)[0]["type"]
          this.services.appraiser_type_id = JSON.parse(this.order.provider_service.appraiser_type_fee)[0]["typeId"]
          this.services.technology_fee = JSON.parse(this.order.provider_service.appraiser_type_fee)[0]["fee"]
      },
      updateProvidedServices() {
        let that = this
        axios.post('update-appraisal-info/' + this.orderId,this.services)
            .then( res => {
              this.message = res.data.message
              setTimeout(function(){
                that.$bvModal.hide('provided-services')
                that.message = ''
              }, 2000);
            }).catch( err =>{
              console.log(err)
        })
      }
    }
  }
</script>
