<template>
    <b-modal id="quick-view" size="md" title="Quick View">
        <button @click="$bvModal.hide('quick-view')" type="button" class="btn-close" aria-label="Close"></button>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-3 fw-bold">Client info</p>
                    <div class="modal-item">
                        <p class="mb-0 text-400">AMC name: </p>
                        <span class="mb-0 text-600 d-block">{{ amc_name }}</span>
                    </div>
                    <a v-if="amc_file != ''" :href="amc_file" target="_blank"
                        class="underline primary-text text-600 d-inline-block mt-3 mb-3" download>AMC
                        requirements</a>
                    <a v-else :href="'#'" @click.prevent
                        class="text-gray text-600 d-inline-block mt-3 mb-3">AMC requirements</a>
                    <div class="modal-item">
                        <p class="mb-0 text-400">Lender/Bank name: </p>
                        <span class="mb-0 text-600 d-block">{{ lender_name }}</span>
                    </div>
                    <div class="modal-item">
                        <p class="mb-0 text-400">Lender/Bank address: </p>
                        <span class="mb-0 text-600 d-block">{{ lender_address }}</span>
                    </div>
                    <a v-if="lender_file" :href="lender_file" target="_blank"
                        class="underline primary-text text-600 d-inline-block mt-3 mb-3" download>Lender
                        requirements</a>
                    <a v-else :href="'#'" @click.prevent
                        class="text-gray text-600 d-inline-block mt-3 mb-3">Lender requirements</a>
                    <div class="mgt-32">
                        <p class="mb-3 text-600">Property info</p>
                        <div class="modal-item">
                            <p class="mb-0 text-400">Property address:</p>
                            <span class="mb-0 text-600 d-block">{{ property_address }}</span>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0 text-400">Due date:</p>
                            <span class="mb-0 text-600 d-block">{{ due_date }}</span>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0 text-400">Client order no: </p>
                            <span class="mb-0 text-600 d-block"> {{ client_order_no }}</span>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0">System order no:
                            </p>
                            <span class="mb-0 text-600 d-block">{{ system_order_no }}</span>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0 text-400">Order receive date: </p>
                            <span class="mb-0 text-600 d-block">{{ received_date }}</span>
                        </div>
                        <div class="mgt-32">
                            <p class="mb-3 text-600">Contact info</p>
                            <div class="modal-item">
                                <p class="mb-0 text-400">Contact name: </p>
                                <span class="mb-0 text-600 d-block">{{ contact_name }}</span>
                            </div>
                            <div class="modal-item">
                                <p class="mb-0 text-400">Phone: </p>
                                <span v-for="phone,index in contact_phone" class="mb-0 text-600 d-block">{{ phone }}
                                    <span v-if="index != Object.keys(contact_phone).length - 1"> , </span> </span>
                            </div>
                            <div class="modal-item">
                                <p class="mb-0 text-400">Email: </p>
                                <span v-for="email,index in contact_email" class="mb-0 text-600 d-block">{{ email }}
                                    <span v-if="index != Object.keys(contact_email).length - 1"> , </span> </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-700 mb-3">Notes</p>
                        <p class="note-text mb-3 text-700">{{ note }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button type="button" variant="secondary" @click="$bvModal.hide('quick-view')">Close</b-button>
        </div>
    </b-modal>
</template>

<script>
    export default {
        name: 'quick-view',
        data: () => ({
            amc_name: '',
            amc_file: '',
            lender_name: '',
            lender_address: '',
            lender_file: '',
            property_address: '',
            due_date: '',
            client_order_no: '',
            system_order_no: '',
            received_date: '',
            contact_name: '',
            contact_phone: '',
            contact_email: '',
            note: '',
        }),
        methods: {
            setQuickViewData(orderData) {
                this.amc_name = orderData.amc.name
                this.amc_file = (orderData.amc.attachments && orderData.amc.attachments[0]) ? orderData.amc.attachments[0].original_url : ''
                this.lender_name = orderData.lender.name
                this.lender_address = orderData.lender.address
                this.lender_file = (orderData.lender.attachments && orderData.lender.attachments[0]) ? orderData.lender.attachments[0].original_url : ''
                this.property_address = orderData.property_info.full_addr
                this.due_date = orderData.due_date
                this.client_order_no = orderData.client_order_no
                this.system_order_no = orderData.system_order_no
                this.received_date = orderData.received_date
                this.contact_name = orderData.contact_info.contact
                this.contact_phone = JSON.parse(orderData.contact_info.contact_email).phone
                this.contact_email = JSON.parse(orderData.contact_info.contact_email).email
                this.note = orderData.provider_service.note
                console.log(this.amc_file)
            }
        }
    }
</script>
