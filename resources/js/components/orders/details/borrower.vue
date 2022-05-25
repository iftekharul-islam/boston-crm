<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Borrower</p>
      <a v-b-modal.borrower-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Borrower name</p>
        <span>:</span>
        <p class="right-side mb-0">{{ borrower_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Co-borrower name</p>
        <span>:</span>
        <p class="right-side mb-0">{{ co_borrower_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Phone</p>
        <span>:</span>
        <p class="right-side mb-0">{{ contact }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Email</p>
        <span>:</span>
        <p class="right-side mb-0">{{ email }}</p>
      </div>
    </div>
    <!-- modal -->
     <b-modal id="borrower-info" class="brrower-modal" size="lg" title="Edit Borrower">
        <div class="modal-body brrower-modal-body">
          <div class="row">
            <div class="col-12">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Borrower name <span class="require"></span></label>
                <input type="text" v-model="borrower_name"  class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Co-borrower name <span class="require"></span></label>
                <input type="text" v-model="co_borrower_name" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Phone <span class="text-danger require"></span></label>
                <input type="text" v-model="contact" class="dashboard-input w-100">
                <div class=" mgt-20">
                  <button class="add-more ">
                    <span class="icon-plus" @click="addContact"></span> Add more
                  </button>
                </div>
              </div>
               <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Email <span class="text-danger require"></span></label>
                <input type="text" v-model="email" class="dashboard-input w-100">
                <div class=" mgt-20">
                  <button class="add-more ">
                    <span class="icon-plus" @click="addEmail"></span> Add more
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <div slot="modal-footer mgt-44">
        <button class="button button-transparent" @click="$bvModal.hide('borrower-info')">Close</button>
        <button class="button button-primary" @click="updateBorrowerInfo">Save</button>
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
      return {
        borrower_name : '',
        co_borrower_name: '',
        contact: '',
        email: ''
      }
    },
    created() {
      this.getBorrowerInfo()
    },
    methods:{
      getBorrowerInfo(){
        axios.get('get-borrower-info/' + this.orderId)
            .then(res => {
              this.borrower_name = res.data.borrower.borrower_name
              this.co_borrower_name = res.data.borrower.co_borrower_name

            }).catch(err => {
              console.log(err)
        })
      },
      updateBorrowerInfo(){

      },
      addEmail(){

      },
      addContact(){

      }
    }
  }
</script>
