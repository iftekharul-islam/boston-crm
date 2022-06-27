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
                <a v-if="amc_file != ''" :href="amc_file" target="_blank" class="underline primary-text text-600"
                    download>AMC
                    requirements</a>
                <a v-else :href="'#'" @click.prevent class="secondary-text text-gray">AMC requirements</a>
            </div>
            <div class="list">
                <div class="list__group mb-3">
                    <p class="mb-0 left-side">Lender name</p>
                    <span>:</span>
                    <p class="right-side mb-0">{{ lender_name }}</p>
                </div>
                <a v-if="lender_file != ''" :href="lender_file" target="_blank" class="underline primary-text text-600"
                    download>Lender requirements</a>
                <a v-else :href="'#'" @click.prevent class="text-gray">Lender requirements</a>
            </div>
        </div>
        <!-- modal -->
        <b-modal id="client-info" size="md" title="Edit client">
            <div class="modal-body">
                <ValidationObserver ref="clientsForm">
                    <div class="row">
                        <div class="col-md-12">
                            <ValidationProvider class="group mb-4" name="AMC Name" rules="required" v-slot="{ errors }">
                                <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">AMC Name <span
                                            class="require"></span></label>
                                    <b-form-select v-model="amc_id" :options="allAmc" value-field="id" text-field="name"
                                        class="dashboard-input w-100">
                                        <template #first>
                                            <b-form-select-option value="" disabled>-- Please select an option --
                                            </b-form-select-option>
                                        </template>
                                    </b-form-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <a v-if="amc_file != ''" :href="amc_file" target="_blank"
                                class="underline primary-text text-600" download>AMC
                                requirements</a>
                            <a v-else :href="'#'" @click.prevent class="secondary-text text-gray">AMC requirements</a>
                            <br>
                            <div class="position-relative file-upload mt-4">
                                <input type="file" @change="changeFileAmc">
                                <label for="">Upload <span class="icon-upload ms-3 fs-20"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></span></label>
                                <span class="primary-text">{{ amcFileName }}</span>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="col-md-12">
                            <ValidationProvider class="group mb-4" name="Lender Name" rules="required"
                                v-slot="{ errors }">
                                <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Lender Name <span
                                            class="require"></span></label>
                                    <m-select v-model="lender_id" @change="changeClientType('lender', $event)" :options="allLender" object item-value="id" item-text="name"></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Lender address</label>
                                <input class="dashboard-input w-100" type="text" v-model="lender_address" />
                                <a v-if="lender_file" :href="lender_file" target="_blank"
                                    class="underline primary-text text-600" download>Lender requirements</a>
                                <a v-else :href="'#'" @click.prevent class="text-gray">Lender requirements</a>
                                <br>
                                <div class="position-relative file-upload mt-4">
                                    <input type="file" @change="changeFileLender">
                                    <label for="">Upload <span class="icon-upload ms-3 fs-20"><span
                                                class="path1"></span><span class="path2"></span><span
                                                class="path3"></span></span></label>
                                    <span class="primary-text">{{ lenderFileName }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </ValidationObserver>
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
                lender_name: '',
                lender_address: '',
                lenderNewFile: '',
                lenderFileName: '',
                amcNewFile: '',
                amcFileName: '',
            }
        },
        created() {
            this.getClientInfo(this.order);
        },
        methods: {
            getClientInfo(order) {
                this.amc_id = order.amc.id
                this.amc_file = order.amc_file
                this.amc_name = order.amc.name
                this.lender_id = order.lender.id
                this.lender_file = order.lender_file
                this.lender_name = order.lender.name
                this.lender_address = order.lender.address
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
                let formData = new FormData()
                formData.append('amc_id', this.amc_id)
                formData.append('lender_id', this.lender_id)
                formData.append('address', this.lender_address)
                formData.append('amc_file', this.amcNewFile)
                formData.append('lender_file', this.lenderNewFile)
                this.$refs.clientsForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('update-client-info/' + this.orderId, formData)
                            .then(res => {
                                this.$root.$emit('wk_update', res.data)
                                this.$root.$emit('wk_flow_toast', res)
                                this.getClientInfo(res.data)
                                this.amc_file = res.amc_file
                                this.lender_file = res.lender_file
                                this.$bvModal.hide('client-info')
                            }).catch(err => {
                                console.error(err)
                            })
                    }
                })
            }
        }
    }
  },
  created() {
    this.getClientInfo(this.order);
  },
  methods: {
    getClientInfo(order) {
        let orderDetails = order
        this.amc_id = orderDetails.amc.id
        this.amc_file = orderDetails.amc_file
        this.amc_name = orderDetails.amc.name
        this.lender_id = orderDetails.lender.id
        this.lender_file = orderDetails.lender_file
        this.lender_name = orderDetails.lender.name
        this.lender_address = orderDetails.lender.address
    },
    changeFileLender(e) {
      this.lenderNewFile = e.target.files[0]
      this.lenderFileName = e.target.files[0].name
    },
    changeFileAmc(e) {
      this.amcNewFile = e.target.files[0]
      this.amcFileName = e.target.files[0].name
    },
    changeClientType(type, value) {
      if (type == 'amc') {
        let amcDetails = this.allAmc.find(ele => ele.id == value);
        if (amcDetails.client_type == 'both') {
            this.lender_id = amcDetails.id;
        }
      } else {
        let lenderDetails = this.allLender.find(ele => ele.id == value);
        if (lenderDetails.client_type == 'both') {
          this.amc_id = lenderDetails.id;
        }
      }
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
            this.getClientInfo(res.data.data)
            that.message = res.data.message
            this.$toast.open({
                message: that.message,
                type: res.error == true ? 'error' : 'success',
            });
            that.$bvModal.hide('client-info');
          }).catch(err => {

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
