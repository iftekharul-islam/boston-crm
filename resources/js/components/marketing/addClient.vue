<template>
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
                                <input type="text" id="address-input" @keyup="getLocation" class="dashboard-input w-100"
                                    v-model="client.address">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
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
</template>
<script>
    export default {
        name: 'add-client',
        data: () => ({
            client: {
                name: '',
                address: '',
                email: '',
                phone: '',
            }
        }),
        methods: {
            getLocation() {
                const center = { lat: 50.064192, lng: -130.605469 };
                // Create a bounding box with sides ~10km away from the center point
                const defaultBounds = {
                    north: center.lat + 0.1,
                    south: center.lat - 0.1,
                    east: center.lng + 0.1,
                    west: center.lng - 0.1,
                };
                //need to make dynamic if get time
                const addressInput = document.getElementById("address-input")

                const options = {
                    bounds: defaultBounds,
                    componentRestrictions: { country: "us" },
                    fields: ["formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["establishment"],
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
                                this.$root.$emit('client_res', res.data)
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
            }
        },
    }
</script>
<style>
    .pac-container {
        z-index: 1051 !important;
    }

</style>
