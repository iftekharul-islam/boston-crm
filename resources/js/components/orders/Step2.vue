<template>
  <div>
    <ValidationObserver ref="orderForm">
    <div class="row mgb-32">
      <div class="col-md-12 ">
        <div class="form-box">
          <h4 class="box-header mb-3">Borrower info</h4>

          <div class="d-flex justify-content-between w-100">
            <div class="left max-w-424 w-100 me-3">
              <ValidationProvider name="Borrower Name" rules="required" v-slot="{ errors }">
                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">Borrower name <span
                      class="text-danger require"></span></label>
                  <input type="text" v-model="step2.borrower_name" class="dashboard-input w-100">
                  <span class="error-message">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
              <ValidationProvider name="Co Borrower Name" rules="required" v-slot="{ errors }">
                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                <label for="" class="d-block mb-2 dashboard-label">Co-borrower name</label>
                <input type="text" v-model="step2.co_borrower_name" class="dashboard-input w-100">
                <span class="error-message">{{ errors[0] }}</span>
              </div>
              </ValidationProvider>
            </div>
            <div class="middle max-w-424 w-100 me-3">
              <ValidationObserver ref="addContactForm">
                <ValidationProvider name="Contact No" :rules="{ 'required' : add.contact == null && step2.borrower_contact == false }" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Contact no <span class="text-danger require"></span></label>
                    <input v-model="add.contact" type="text" class="dashboard-input w-100">
                    <span class="error-message">{{ errors[0] }}</span>
                    <div class="text-end mgt-20">
                      <button class="add-more " @click="addContact">
                        <span class="icon-plus"></span> Add
                      </button>
                    </div>
                    <div class="new-array-items">
                      <div class="items" v-for="item, ki in step2.borrower_contact_s" :key="ki">
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
            </div>
            <div class="right max-w-424 w-100">
              <ValidationObserver ref="addEmailForm">
                <ValidationProvider name="Email Address" :rules="{ 'required' : add.email == null && step2.borrower_email == false }" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Email address <span
                        class="text-danger require"></span></label>
                    <input v-model="add.email" type="text" class="dashboard-input w-100">
                    <span class="error-message">{{ errors[0] }}</span>
                    <div class="text-end mgt-20">
                      <button class="add-more" @click="addEmail">
                        <span class="icon-plus"></span> Add
                      </button>
                    </div>
                    <div class="new-array-items">
                      <div class="items" v-for="item, ki in step2.borrower_email_s" :key="ki">
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

      </div>
    </div>
    <div class="row">
      <div class="col-md-12 ">
        <div class="form-box">
          <h4 class="box-header mb-3">Contact info</h4>
          <div class="group checkbox-group position-relative mb-2">
            <input v-model="step2.contactSame" type="checkbox" class=" checkbox-input w-100">
            <label for="" class="checkbox-label text-primary">Set borrower as contact</label>
          </div>
          <div class="d-flex justify-content-between w-100">
            <div class="left max-w-424 w-100 me-3">
              <ValidationProvider name="Contact Info" :rules="{'required' : step2.contactSame == false}" v-slot="{ errors }">
                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                  <label for="" class="d-block mb-2 dashboard-label">Contact <span
                      class="text-danger require"></span></label>
                  <textarea :disabled="step2.contactSame == true" v-model="step2.contact_info" name="" class="dashboard-textarea w-100" id="" cols="30" rows="3"></textarea>
                  <span class="error-message">{{ errors[0] }}</span>
                </div>
              </ValidationProvider>
            </div>
            <div class="middle max-w-424 w-100 me-3">
              <ValidationObserver ref="addContact2form">
                  <ValidationProvider name="Contact Number" :rules="{'required' : add.contact2 == null && step2.contactSame == false && step2.contact_number == false}" v-slot="{ errors }">
                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                      <label for="" class="d-block mb-2 dashboard-label">Contact no <span class="text-danger require"></span></label>
                      <input :disabled="step2.contactSame == true" v-model="add.contact2" type="text" class="dashboard-input w-100">
                      <span class="error-message">{{ errors[0] }}</span>
                      <div class="text-end mgt-20">
                        <button class="add-more " @click="addContact2">
                          <span class="icon-plus"></span> Add
                        </button>
                      </div>
                      <div class="new-array-items">
                        <div class="items" v-for="item, ki in step2.contact_number_s" :key="ki">
                          <div class="item-content"> {{ item }} </div>
                          <div class="item-remove">
                            <button class="btn btn-sm btn-danger" @click="removeItem(ki, 'contact2')">
                              Remove
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </ValidationProvider>
              </ValidationObserver>
            </div>
            <div class="right max-w-424 w-100">
              <ValidationObserver ref="addEmail2form">
                  <ValidationProvider name="Contact Email Address" :rules="{'required' : add.email2 == null && step2.contactSame == false && step2.email_address == false}" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="" class="d-block mb-2 dashboard-label">Email address <span
                        class="text-danger require"></span></label>
                    <input :disabled="step2.contactSame == true" v-model="add.email2" type="text" class="dashboard-input w-100">
                    <span class="error-message">{{ errors[0] }}</span>
                    <div class="text-end mgt-20">
                      <button class="add-more" @click="addEmail2">
                        <span class="icon-plus"></span> Add
                      </button>
                    </div>
                    <div class="new-array-items">
                      <div class="items" v-for="item, ki in step2.email_address_s" :key="ki">
                        <div class="item-content"> {{ item }} </div>
                        <div class="item-remove">
                          <button class="btn btn-sm btn-danger" @click="removeItem(ki, 'email2')">
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
      </div>
    </div>
    <div class="d-flex">
      <div class="group mgt-32 mgb-32">
        <h4 class="box-header mb-3">Upload order form</h4>
        <div class="position-relative file-upload">
          <input type="file" @change="addFile">
          <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
          <span class="text-success">{{ step2.fileName }}</span>
        </div>
      </div>
      <div class="group mgt-32 mgb-32 mgl-32">
        <h4 class="box-header mb-3">Store as Rush Order</h4>
        <label for="rushOrder">
          <input type="checkbox" v-model="step2.rush" id="rushOrder" class="pr-2">
          Rush
        </label>
      </div>
    </div>
    <div class="add-client__bottom d-flex justify-content-end  p-3">
      <a href="/orders/create" class="button button-discard me-3 d-flex align-items-center">Discard <span class="icon-close-circle ms-3"><span class="path1"></span><span class="path2"></span></span></a>
      <button class="button button-primary" v-if="type == 2" @click="addNewOrder(true)"> Update order </button>
      <button class="button button-primary" v-else @click="addNewOrder"> Add order </button>
    </div>
    </ValidationObserver>
  </div>
</template>

<script>
export default {
  name: "Step2",
  props: ['type', 'order'],
  data: () => ({
      step2: {
        borrower_name: null,
        co_borrower_name: null,
        borrower_contact: false,
        borrower_email: false,
        borrower_contact_s: [],
        borrower_email_s: [],
        contactSame: false,
        contact_info: null,
        contact_number: false,
        email_address: false,
        rush: 0,
        contact_number_s: [],
        email_address_s: [],
        file: '',
        fileName: ''
      },
      add: {
        contact: null,
        email: null,
        contact2: null,
        email2: null
      }
  }),
  created(){
    this.$root.$on('orderSubmitConfirm', (status) => {
        this.removeDataValue();
    });
    if (this.type == 2) {
      this.setStep2Data();
    }
  },
  methods: {
    addFile(event){
        let that = this
        let fileData = event.target.files[0]
        var reader = new FileReader();
        reader.readAsDataURL(fileData);
        reader.onload = function () {
            that.step2.file = reader.result
        };
      this.step2.fileName = fileData.name
    },
    addEmail2() {
        this.$refs.addEmail2form.validate().then((status) => {
            if (status) {
                let newEmail = this.add.email2;
                let findOld = this.step2.email_address_s.find((ele) =>  ele == newEmail);
                if (!findOld && newEmail != null) {
                  this.step2.email_address_s.push(newEmail);
                  this.add.email2 = null;
                  this.step2.email_address = true;
                }
            }
        });
    },
    addContact2() {
        this.$refs.addContact2form.validate().then((status) => {
            if (status) {
                let newContact = this.add.contact2;
                let findOld = this.step2.contact_number_s.find((ele) =>  ele == newContact);
                if (!findOld && newContact != null) {
                  this.step2.contact_number_s.push(newContact);
                  this.add.contact2 = null;
                  this.step2.contact_number = true;
                }
            }
        });
    },
    addEmail() {
        this.$refs.addEmailForm.validate().then((status) => {
            if (status) {
                let newEmail = this.add.email;
                let findOld = this.step2.borrower_email_s.find((ele) =>  ele == newEmail);
                if (!findOld && newEmail != null) {
                  this.step2.borrower_email_s.push(newEmail);
                  this.add.email = null;
                  this.step2.borrower_email = true;
                }
            }
        });
    },
    addContact() {
        this.$refs.addContactForm.validate().then((status) => {
            if (status) {
                let newContact = this.add.contact;
                let findOld = this.step2.borrower_contact_s.find((ele) =>  ele == newContact);
                if (!findOld && newContact != null) {
                  this.step2.borrower_contact_s.push(newContact);
                  this.add.contact = null;
                  this.step2.borrower_contact = true;
                }
            }
        });
    },
    removeItem(index, type) {
      if (type == 'email2') {
          this.step2.email_address_s.splice(index, 1);
          if (this.step2.email_address_s.length == 0) {
            this.step2.email_address = false;
          }
      } else if (type == 'email') {
          this.step2.borrower_email_s.splice(index, 1);
          if (this.step2.borrower_email_s.length == 0) {
            this.step2.borrower_email = false;
          }
      } else if (type == 'contact') {
          this.step2.borrower_contact_s.splice(index, 1);
          if (this.step2.borrower_contact_s.length == 0) {
            this.step2.borrower_contact = false;
          }
      } else if (type == 'contact2') {
          this.step2.contact_number_s.splice(index, 1);
          if (this.step2.contact_number_s.length == 0) {
            this.step2.contact_number = false;
          }
      }
    },
    addNewOrder(type = false) {
        this.$refs.orderForm.validate().then((res) => {
          this.$root.$emit("updateStepData", {
            step: 2,
            data: this.step2
          });
          this.$root.$emit("submitOrder", type);
      });
    },
    removeDataValue() {
        let newData = [];
        for (let i in this.step2) {
          newData.i = null;
          if (i == "borrower_contact_s" || i == "borrower_email_s" || i == "contact_number_s" || i == "email_address_s") {
              newData.i = [];
          } else if (i == "rush") {
            newData.i = 0;
          }
        }
        this.step2 = newData;
        this.$refs.addContactForm.reset();
    },
    setStep2Data() {
      let borrowerContact = JSON.parse(this.order.borrower_info.contact_email);
      let borrowerEmail = borrowerContact['email'];
      let borrowerPhone = borrowerContact['phone'];

      let contactInfo = JSON.parse(this.order.contact_info.contact_email);
      let contactInfoEmail = contactInfo['email'];
      let contactInfoPhone = contactInfo['phone'];

      let step2 = {
        borrower_name: this.order.borrower_info.borrower_name,
        co_borrower_name: this.order.borrower_info.co_borrower_name,
        borrower_contact: borrowerPhone.length ? true : false,
        borrower_email: borrowerEmail.length ? true : false,
        borrower_contact_s: borrowerPhone,
        borrower_email_s: borrowerEmail,
        contactSame: this.order.contact_info.is_borrower,
        contact_info: this.order.contact_info.contact,
        contact_number: contactInfoPhone.length ? true : false,
        email_address: contactInfoEmail.length ? true : false,
        contact_number_s: contactInfoPhone,
        rush: this.order.rush,
        email_address_s: contactInfoEmail,
      };
      this.step2 = step2;
    }
  },
  watch: {
    step2: {
      handler(val) {
        this.$root.$emit("updateStepData", {
          step: 2,
          data: val
        });
      },
      deep: true
    }
  }
}
</script>

<style scoped>
.new-array-items{
  margin-top: 15px;
}
.new-array-items .items {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}
.new-array-items .items:nth-last-child(1) {
  border-bottom: unset;
  margin-bottom: 0;
}
</style>
