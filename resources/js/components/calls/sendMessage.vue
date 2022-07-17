<template>
    <b-modal id="send-message" size="md" title="Send messages">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <ValidationObserver ref="sendMessageForm">
                        <div class="group">
                            <label for="" class="d-block mb-1">Receipant email <span
                                    class="text-danger require"></span></label>
                            <p class="dashboard-input w-100"><span v-for="email,index in sendMessageData.emails">{{
                                    email }}
                                    <span v-if="index != Object.keys(sendMessageData.emails).length - 1">, </span>
                                </span></p>
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-1">Mobile no <span
                                    class="text-danger require"></span></label>
                            <p class="dashboard-input w-100"><span v-for="phone,index in sendMessageData.phones">{{
                                    phone }}
                                    <span v-if="index != Object.keys(sendMessageData.phones).length - 1">, </span>
                                </span></p>
                        </div>
                        <div class="group">
                            <ValidationProvider class="d-block mb-2 dashboard-label" name="Subject" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Subject <span
                                            class="text-danger require"></span></label>
                                    <input type="text" v-model="sendMessageData.subject" class="dashboard-input w-100">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </div>
                        <div class="group">
                            <ValidationProvider class="d-block mb-2 dashboard-label" name="Messages" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-1">Messages <span
                                            class="text-danger require"></span></label>
                                    <textarea v-model="sendMessageData.message" cols="30" rows="3"
                                        class="dashboard-textarea w-100 br-8" placeholder="Type here..."></textarea>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </validationProvider>
                        </div>
                        <div>
                            <p class="mgb-12">Send message to</p>
                            <div class="d-flex">
                                <div class="checkbox-group mgr-32">
                                    <input type="checkbox" @change="emailCheckbox" class="checkbox-input">
                                    <label for="" class="checkbox-label">Email</label>
                                </div>
                                <div class="checkbox-group">
                                    <input type="checkbox" @click="smsCheckbox" class="checkbox-input">
                                    <label for="" class="checkbox-label">SMS</label>
                                </div>
                            </div>
                        </div>
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button variant="secondary" @click="$bvModal.hide('send-message')">Close</b-button>
            <b-button variant="primary" @click="sendMessage">Send</b-button>
        </div>
    </b-modal>
</template>
<script>
    export default {
        data() {
            return {
                sendMessageData: {
                    emails: '',
                    phones: '',
                    subject: '',
                    message: '',
                    send_email: 0,
                    send_sms: 0,
                    order_id: 0
                }
            }
        },
        methods: {
            emailCheckbox(event) {
                event.currentTarget.checked ? this.sendMessageData.send_email = 1 : this.sendMessageData.send_email = 0
            },
            smsCheckbox(event) {
                event.currentTarget.checked ? this.sendMessageData.send_sms = 1 : this.sendMessageData.send_sms = 0
            },
            setContactData(contactData, property, lender) {
                this.sendMessageData.order_id = contactData.order_id
                this.sendMessageData.emails = (JSON.parse(contactData.contact_email)).email
                this.sendMessageData.phones = (JSON.parse(contactData.contact_email)).phone
                let lenderName = lender.name
                let propertyAddress = property.full_addr

                let formattedMessage = "Hello, We have been assigned an appraisal through the " + lenderName + ". We need to schedule an appointment to complete an appraisal inspection of the subject property located at " + propertyAddress + ". Please call our offices or email us at your earliest convenience. You can reach us at 617-440-7700 or via email at orders@bostonappraisal.com. Thank you !";
                this.sendMessageData.message = formattedMessage;
            },
            sendMessage() {
                this.$refs.sendMessageForm.validate().then((status) => {
                    if (status) {
                        if (this.sendMessageData.send_email == 0 && this.sendMessageData.send_sms == 0) {
                            this.$toast.open({
                                message: "Please select atleast one method (Email or SMS)",
                                type: 'error',
                            });
                            return false;
                        }else{
                            this.$boston.post('send-message', this.sendMessageData)
                            .then(res => {
                                this.$bvModal.hide('send-message')
                                this.$root.$emit('wk_flow_toast', res)
                            })
                            .catch(err => {
                                console.error(err)
                            })
                        }
                    }
                })
            }
        }
    }
</script>
