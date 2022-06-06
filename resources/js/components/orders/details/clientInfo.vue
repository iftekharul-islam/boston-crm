<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Client</p>
      <a v-b-modal.client-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span
          class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list mb-3">
        <div class="list__group mb-3">
          <p class="mb-0 left-side">AMC name</p>
          <span>:</span>
          <p class="right-side mb-0">{{ amc_name }}</p>
        </div>
        <a :href="amc_file !== '' || amc_file !== null ? amc_file : '#'" target="_blank" class="underline primary-text text-600">AMC requirements</a>
      </div>
      <div class="list">
        <div class="list__group mb-3">
          <p class="mb-0 left-side">Lender name</p>
          <span>:</span>
          <p class="right-side mb-0">{{ lender_name }}</p>
        </div>
        <a :href="lender_file" target="_blank" class="underline primary-text text-600">Lender requirements</a>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="client-info" size="md" title="Edit client">
      <div class="modal-body">
        <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
        <div class="row">
          <div class="col-md-12">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">AMC Name <span class="require"></span></label>
              <b-form-select
                  v-model="amc_id"
                  :options="allAmc"
                  value-field="id"
                  text-field="name"
                  class="dashboard-input w-100">
                <template #first>
                  <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                </template>
              </b-form-select>
            </div>
            <a :href="amc_file" target="_blank" class="primary-text fw-bold my-3 d-block underline">AMC
              requirements 1</a>
            <div class="position-relative file-upload">
              <input type="file" @change="changeFileAmc">
              <label for="">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span
                  class="path2"></span><span class="path3"></span></span></label>
              <span class="text-primary">{{ amcFileName }}</span>
            </div>
          </div>
          <div class="divider"></div>
          <div class="col-md-12">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Lender Name <span class="require"></span></label>
              <b-form-select
                  v-model="lender_id"
                  :options="allLender"
                  value-field="id"
                  text-field="name"
                  class="dashboard-input w-100">
                <template #first>
                  <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                </template>
              </b-form-select>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Lender address</label>
              <input class="dashboard-input w-100" type="text" :value="lender_address"/>
              <a :href="lender_file" target="_blank" class="primary-text fw-bold my-3 d-block underline">Lender
                requirements 1</a>
              <div class="position-relative file-upload">
                <input type="file" @change="changeFileLender">
                <label for="">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span
                    class="path2"></span><span class="path3"></span></span></label>
                <span class="text-primary">{{ lenderFileName }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('client-info')">Close</b-button>
        <b-button variant="primary" @click="saveClient">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: {
    orderId: String,
    order: [],
    allAmc: [],
    allLender: []
  },
  data() {
    return {
      amc_id: '',
      amc_file: '',
      amc_name: '',
      lender_id: '',
      lender_file: '',
      lender_name:'',
      lender_address: '',
      lenderNewFile: '',
      lenderFileName: '',
      amcNewFile: '',
      amcFileName: '',
      message: '',
    }
  },
  created() {
    this.getClientInfo();
  },
  methods: {
    getClientInfo() {
        this.amc_id = this.order.amc.id
        this.amc_file = this.order.amc_file
        this.amc_name = this.order.amc.name
        this.lender_id = this.order.lender.id
        this.lender_file = this.order.lender_file
        this.lender_name = this.order.lender.name
        this.lender_address = this.order.lender.address
    },
    changeFileLender(e) {
      this.lenderNewFile = e.target.files[0]
      this.lenderFileName = e.target.files[0].name
    },
    changeFileAmc(e) {
      this.amcNewFile = e.target.files[0]
      this.amcFileName = e.target.files[0].name
    },
    saveClient() {
      let that = this
      let formData = new FormData()
      formData.append('amc_id', this.amc_id)
      formData.append('lender_id', this.lender_id)
      formData.append('address', this.lender_address)
      formData.append('amc_file', this.amcNewFile)
      formData.append('lender_file', this.lenderNewFile)

      axios.post('update-client-info/' + this.orderId, formData)
          .then(res => {
            that.message = res.data.message
            setTimeout(function () {
              that.$bvModal.hide('client-info')
              that.message = ''
            }, 2000);
          }).catch(err => {
        console.log(err)
      })
    }
  }
}
</script>

<style scoped>

.divider {
    border-top: 4px solid #35a6dc;
    background: transparent;
    padding-top: 20px;
    margin-top: 20px;
}

</style>
