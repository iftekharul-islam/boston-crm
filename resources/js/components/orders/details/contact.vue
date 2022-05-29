<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Contact</p>
      <a v-b-modal.contact-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Contact name</p>
        <span>:</span>
        <p class="right-side mb-0">John Doe</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Phone</p>
        <span>:</span>
        <p class="right-side mb-0">25 Jun 2022</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Email</p>
        <span>:</span>
        <p class="right-side mb-0">25 Jun 2022</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Address</p>
        <span>:</span>
        <p class="right-side mb-0">1453 Dorchester Ave, Boston,
          Ma 02122</p>
      </div>
    </div>
    <!-- modal -->
    <b-modal id="contact-info" class="brrower-modal" size="lg" title="Edit Contact">
      <div class="modal-body brrower-modal-body">
        <div class="row">
          <div class="col-12">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Contact name</label>
              <input type="text" v-model="co_borrower_name" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Phone </label>
              <input type="text" v-model="contact" class="dashboard-input w-100">
              <div class=" mgt-20">
                <button class="add-more ">
                  <span class="icon-plus" @click="addContact"></span> Add more
                </button>
              </div>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Email </label>
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
        <button class="button button-transparent" @click="$bvModal.hide('contact-info')">Close</button>
        <button class="button button-primary" @click="updateContactInfo">Save</button>
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
        is_borrower: '',
        borrower_name: '',
        co_borrower_name: '',
        contact:'',
        email:'',
      }
    },
    created() {
      this.getContactInfo()
    },
    methods:{
      getContactInfo(){
        // axios.get('get-contact-info/' + this.orderId)
        //     .then(res => {
        //       this.is_borrower = res.data.contact.is_borrower
        //       this.contact = res.data.contact.contact
        //
        //     }).catch(err => {
        //   console.log(err)
        // })
      },
      updateContactInfo(){

      },
      addEmail(){

      },
      addContact(){

      }
    }

  }
</script>
