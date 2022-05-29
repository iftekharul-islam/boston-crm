<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Client</p>
      <a v-b-modal.client-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list mb-3">
        <div class="list__group mb-3">
          <p class="mb-0 left-side">AMC name</p>
          <span>:</span>
          <p class="right-side mb-0">{{ amc_name }}</p>
        </div>
        <a :href="amc_file" target="_blank" class="underline primary-text text-600">AMC requirements</a>
      </div>
      <div class="list">
        <div class="list__group mb-3">
          <p class="mb-0 left-side">Lender name</p>
          <span>:</span>
          <p class="right-side mb-0">{{ lender_name}}</p>
        </div>
        <a :href="lender_file" target="_blank" class="underline primary-text text-600">Lender requirements</a>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="client-info" size="lg" title="Edit client">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">AMC name</label>
                <input type="text" class="dashboard-input w-100" :value="amc_name">
                <a :href="amc_file" target="_blank" class="primary-text fw-bold my-3 d-inline-block underline">AMC requirements 1</a>
                <div class="position-relative file-upload">
                    <input type="file">
                    <label for="">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                  </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Lender/ Bank name</label>
                <input type="text" class="dashboard-input w-100" :value="lender_name">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Lender address</label>
                <input class="dashboard-input w-100" type="text" :value="lender_address"></input>
                <a :href="lender_file" target="_blank" class="primary-text fw-bold my-3 d-inline-block underline">Lender requirements 1</a>
                <div class="position-relative file-upload">
                    <input type="file">
                    <label for="">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                  </div>
              </div>
            </div>
          </div>
        </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('client-info')">Close</b-button>
        <b-button variant="primary">Save</b-button>
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
        amc_id: '',
        amc_name:'',
        amc_file:'',
        lender_id: '',
        lender_name:'',
        lender_file:'',
        lender_address: '',
      }
    },
    created(){
      this.getClientInfo()
    },
    methods:{
      getClientInfo(){
        axios.get('get-clients-info/' + this.orderId)
            .then(res => {
              this.amc_id = res.data.clients.amc.id
              this.amc_name = res.data.clients.amc.name
              this.amc_file = res.data.amc_file
              this.lender_id = res.data.clients.lender.id
              this.lender_name = res.data.clients.lender.name
              this.lender_file = res.data.lender_file
              this.lender_address = res.data.clients.lender.address
            }).catch(err => {
              console.log(err)
        })
      }
    }
  }
</script>
