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
                        <div class="col-md-6">
                            <ValidationProvider class="group mb-4" name="AMC Name" rules="required" v-slot="{ errors }">
                                <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">AMC name <span
                                            class="require"></span></label>
                                    <m-select v-model="amc_id" @change="changeClientType('amc', $event)"
                                        :options="allAmc" object item-value="id" item-text="name"></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <a v-if="amc_file != ''" :href="amc_file" target="_blank"
                                class="underline primary-text text-600 d-inline-block mt-3 mb-3" download>AMC
                                requirements</a>
                            <a v-else :href="'#'" @click.prevent class="underline primary-text text-600 d-inline-block mt-3 mb-3">AMC requirements</a>
                            <div class="position-relative file-upload d-block">
                                <input type="file" @change="changeFileAmc">
                                <label for="">Upload <span class="icon-upload ms-3 fs-20"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></span></label>
                                <span class="primary-text text-ellips max-w-150 d-block">{{ amcFileName }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ValidationProvider class="group d-block" name="Lender Name" rules="required"
                                v-slot="{ errors }">
                                <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Lender name <span
                                            class="require"></span></label>
                                    <m-select v-model="lender_id" @change="changeClientType('lender', $event)"
                                        :options="allLender" object item-value="id" item-text="name"></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <span class="group d-block">
                                <label for="" class="d-block mb-2 dashboard-label">Lender address</label>
                                <input class="dashboard-input w-100" type="text" v-model="lender_address" />
                                <a v-if="lender_file" :href="lender_file" target="_blank"
                                    class="underline primary-text text-600 d-inline-block mt-3 mb-3" download>Lender requirements</a>
                                <a v-else :href="'#'" @click.prevent class="underline primary-text text-600 d-inline-block mt-3 mb-3">Lender requirements</a>
                                <div class="position-relative file-upload d-block">
                                    <input type="file" @change="changeFileLender">
                                    <label for="">Upload <span class="icon-upload ms-3 fs-20"><span
                                                class="path1"></span><span class="path2"></span><span
                                                class="path3"></span></span></label>
                                    <span class="primary-text text-ellips max-w-150 d-block">{{ lenderFileName }}</span>
                                </div>
                            </span>
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
</script>

<style scoped>
    .divider {
        border-top: 4px solid #35a6dc;
        background: transparent;
        padding-top: 20px;
        margin-top: 20px;
    }
</style>
