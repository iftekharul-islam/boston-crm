<template>
    <div>
        <b-modal id="add-client" size="md" title="Add Client">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="addClientForm">
                            <ValidationProvider class="group d-block" name="Client name" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Client name <span
                                            class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100" v-model="client.name">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="group d-block" name="Client Address" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Client address <span
                                            class="text-danger require"></span></label>
                                    <input type="text" id="address-input" @keyup="getLocation"
                                        class="dashboard-input w-100" v-model="client.address">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="group d-block" name="Client Category" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Client Category <span
                                            class="text-danger require"></span></label>
                                    <m-select :options="categories" object item-text="name" item-value="id"
                                        v-model="client.category_id"></m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                                <a href="javascript:;" class="btn btn-transparent" @click.prevent="addCategory">+ Add
                                    new category</a>
                            </ValidationProvider>
                            <ValidationProvider class="group d-block" name="Client Email"
                                :rules="{required: true,email:true}" v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Client email <span
                                            class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100" v-model="client.email">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                            <ValidationProvider class="group d-block" name="Client phone"
                                :rules="{ required: true,min: 10, max: 12 }" v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Client phone <span
                                            class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100" @input="phoneValidation"
                                        v-model="client.phone">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button type="button" variant="secondary" @click="$bvModal.hide('add-client')">Close</b-button>
                <b-button type="button" variant="primary" @click="saveClient">Save</b-button>
            </div>
        </b-modal>
        <b-modal id="add-category" size="md" title="Add new category">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="addCategoryForm">
                            <ValidationProvider class="group d-block" name="Category Name" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Category Name<span
                                            class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100" placeholder="Enter category name"
                                        v-model="categoryName">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button type="button" variant="secondary" @click="$bvModal.hide('add-category')">Close</b-button>
                <b-button type="button" variant="primary" @click="saveCategory">Save</b-button>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: 'add-client',
        props: {
            categories: []
        },
        data: () => ({
            client: {
                name: '',
                address: '',
                category_id: '',
                email: '',
                phone: '',
            },
            categoryName: '',
            allCategories: []
        }),
        methods: {
            getLocation() {
                const center = { lat: 42.361145, lng: -71.057083 };
                const addressInput = document.getElementById("address-input")

                const options = {
                    componentRestrictions: { country: "us" },
                    fields: ["formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["address"],
                };
                const autocomplete = new google.maps.places.Autocomplete(addressInput, options);
                let self = this
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace()
                    self.client.address = place.formatted_address
                })
            },
            saveClient() {
                this.$refs.addClientForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('save-marketing-client', this.client)
                            .then(res => {
                                this.$root.$emit('client_res', res)
                                this.$root.$emit('toast_msg', res)
                                this.$bvModal.hide('add-client')
                                this.client = {}
                            })
                            .catch(err => {
                                console.error(err)
                            })
                    }
                })
            },
            phoneValidation(e) {
                let phoneNo = e.target.value;
                let formatedNumber = this.$boston.formatPhoneNo(phoneNo);
                this.client.phone = formatedNumber
            },
            addCategory() {
                this.$bvModal.show('add-category')
            },
            saveCategory(){
                this.$refs.addCategoryForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('save-marketing-client-category', {name: this.categoryName})
                            .then(res => {
                                this.categories = res.data
                                this.$root.$emit('toast_msg', res)
                                this.$bvModal.hide('add-category')
                                this.categoryName = ''
                            })
                            .catch(err => {
                                console.error(err)
                            })
                    }
                })
            }
        }
    }
</script>
<style>
    .pac-container {
        z-index: 1051 !important;
    }

</style>
