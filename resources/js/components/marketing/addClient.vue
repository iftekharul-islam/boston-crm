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
                                <input type="text" class="dashboard-input w-100" v-model="client.address">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="group d-block" name="Client Email" rules="required"
                            v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Client email <span
                                        class="text-danger require"></span></label>
                                <input type="text" class="dashboard-input w-100" v-model="client.email">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="group d-block" name="Client phone" rules="required"
                            v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Client name <span
                                        class="text-danger require"></span></label>
                                <input type="text" class="dashboard-input w-100" v-model="client.phone">
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
    export default{
        name: 'add-client',
        data: () => ({
            client:{
                name: '',
                address: '',
                email: '',
                phone: '',
            }
        }),
        methods:{
            saveClient(){
                console.log(this.client)
            }
        }
    }
</script>
