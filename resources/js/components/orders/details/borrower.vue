<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Borrower</p>
      <a v-b-modal.borrower-info class="d-inline-flex edit align-items-center fw-bold cursor-pointer">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="alert-message alert alert-success" v-if="submittedMessage">
        {{ submittedMessage }}
      </div>
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
        <p class="right-side list-items mb-0">
          <span v-for="item, ik in borrower_contact_s" :key="ik"> {{ item }} </span>
        </p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Email</p>
        <span>:</span>
        <p class="right-side list-items mb-0">
          <span v-for="item, ik in borrower_email_s" :key="ik"> {{ item }} </span>
        </p>
      </div>
    </div>
    <!-- modal -->
    <ValidationObserver ref="orderForm">
     <b-modal id="borrower-info" class="brrower-modal" size="lg" title="Edit Borrower">
        <div class="modal-body brrower-modal-body">
          <div class="row">
            <div class="col-12">

              <ValidationProvider name="Borrower Name" rules="required" v-slot="{ errors }">
                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">Borrower name <span class="require"></span></label>
                  <input type="text" v-model="borrower_name"  class="dashboard-input w-100">
                  <span class="error-message">{{ errors[0] }}</span>
              </div>
              </ValidationProvider>

              <ValidationProvider name="Co-borrower Name" rules="required" v-slot="{ errors }">
                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">Co-borrower name <span class="require"></span></label>
                  <input type="text" v-model="co_borrower_name" class="dashboard-input w-100">
                    <span class="error-message">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>

              <ValidationObserver ref="addContactForm">
                <ValidationProvider name="Contact No" :rules="{ 'required' : add.contact == null && borrower_contact == false, min: 10, max: 12 }" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Contact no <span class="text-danger require"></span></label>
                    <input v-model="add.contact" type="text" class="dashboard-input w-100" @input="contactNumberChecking($event, 1)">
                    <span class="error-message">{{ errors[0] }}</span>
                    <div class="text-end mgb-20">
                      <button class="add-more " @click="addContact">
                        <span class="icon-plus"></span> Add
                      </button>
                    </div>
                    <div class="new-array-items">
                      <div class="items" v-for="item, ki in borrower_contact_s" :key="ki">
                        <div class="item-content"> {{ item }} </div>
                        <div class="item-remove">
                          <button class="btn btn-sm btn-danger" @click="removeItem(ki, 'contact')">
                            Remove
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </ValidationProvider>
              </ValidationObserver>

              <div class="divider"></div>

               <ValidationObserver ref="addEmailForm">
                <ValidationProvider name="Email Address" :rules="{ 'required' : add.email == null && borrower_email == false }" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Email address <span
                        class="text-danger require"></span></label>
                    <input v-model="add.email" type="text" class="dashboard-input w-100">
                    <span class="error-message">{{ errors[0] }}</span>
                    <div class="text-end mgb-20">
                      <button class="add-more" @click="addEmail">
                        <span class="icon-plus"></span> Add
                      </button>
                    </div>
                    <div class="new-array-items">
                      <div class="items" v-for="item, ki in borrower_email_s" :key="ki">
                        <div class="item-content"> {{ item }} </div>
                        <div class="item-remove">
                          <button class="btn btn-sm btn-danger" @click="removeItem(ki, 'email')">
                            Remove
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </ValidationProvider>
              </ValidationObserver>

            </div>
          </div>
        </div>
        <div slot="modal-footer" class="mgt-44">
          <button class="button button-transparent" @click="$bvModal.hide('borrower-info')">Close</button>
          <button class="button button-primary" @click="updateBorrowerInfo">Save</button>
        </div>
    </b-modal>
    </ValidationObserver>
  </div>
</template>
<script>
  export default {
    props:{
      orderId: String,
      order: []
    },
    data(){
      return {
        submittedMessage: null,

        borrower_name: null,
        co_borrower_name: null,
        borrower_contact: false,
        borrower_email: false,
        borrower_contact_s: [],
        borrower_email_s: [],

        add: {
          contact: null,
          email: null,
          contact2: null,
          email2: null
        }
      }
    },
    created() {
      this.getBorrowerInfo()
    },
    methods:{
      getBorrowerInfo(){
        let borrowerContact = JSON.parse(this.order.borrower_info.contact_email);
        let borrowerEmail = borrowerContact['email'];
        let borrowerPhone = borrowerContact['phone'];

        this.borrower_name = this.order.borrower_info.borrower_name;
        this.co_borrower_name = this.order.borrower_info.co_borrower_name;
        this.borrower_contact = borrowerPhone.length ? true : false;
        this.borrower_email = borrowerEmail.length ? true : false;
        this.borrower_contact_s = borrowerPhone;
        this.borrower_email_s = borrowerEmail;
      },
      contactNumberChecking(e, type){
          let phoneNo = e.target.value;
          let formatedNumber = this.$boston.formatPhoneNo(phoneNo);
          this.add.contact = formatedNumber;
      },
      updateBorrowerInfo(){
          this.$refs.orderForm.validate().then((status) => {
              if (status) {
                  this.$boston.post('order/update/borrower', {
                    borrower_name: this.borrower_name,
                    co_borrower_name: this.co_borrower_name,
                    borrower_contact: this.borrower_contact,
                    borrower_email: this.borrower_email,
                    borrower_contact_s: this.borrower_contact_s,
                    borrower_email_s: this.borrower_email_s,
                    order: this.order
                  }).then(res => {
                      this.submittedMessage = res.messages;
                      this.$bvModal.hide('borrower-info');
                      this.hideSubmittedMessage();
                  });
              }
          });
      },
      addEmail() {
          this.$refs.addEmailForm.validate().then((status) => {
              if (status) {
                  let newEmail = this.add.email;
                  let findOld = this.borrower_email_s.find((ele) =>  ele == newEmail);
                  if (!findOld && newEmail != null) {
                    this.borrower_email_s.push(newEmail);
                    this.add.email = null;
                    this.borrower_email = true;
                  }
              }
          });
      },
      addContact() {
          this.$refs.addContactForm.validate().then((status) => {
              if (status) {
                  let newContact = this.add.contact;
                  let findOld = this.borrower_contact_s.find((ele) =>  ele == newContact);
                  if (!findOld && newContact != null) {
                    this.borrower_contact_s.push(newContact);
                    this.add.contact = null;
                    this.borrower_contact = true;
                  }
              }
          });
      },
      removeItem(index, type) {
        if (type == 'email') {
            this.borrower_email_s.splice(index, 1);
            if (this.borrower_email_s.length == 0) {
              this.borrower_email = false;
            }
        } else if (type == 'contact') {
            this.borrower_contact_s.splice(index, 1);
            if (this.borrower_contact_s.length == 0) {
              this.borrower_contact = false;
            }
        }
      },
      hideSubmittedMessage() {
          setTimeout(() => {
            this.submittedMessage = null;
          },5000);
      }
    }
  }
</script>


<style scoped>
.new-array-items .items {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    border-bottom: thin solid #ddd;
    padding-bottom: 10px;
}
.new-array-items .items:nth-last-child(1) {
    margin-bottom: 0px;
    border-bottom: unset;
}
.divider {
    border-top: 4px solid #35a6dc;
    background: transparent;
    padding-top: 20px;
    margin-top: 20px;
}

</style>
