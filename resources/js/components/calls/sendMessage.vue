<template>
    <b-modal id="send-message" size="md" title="Send messages">
        <div class="card mb-4">
            <div class="card-body bg-light text-dark">
                <h5 class="card-title">Property address: </h5>
                <h6 class="card-subtitle">{{ propertyAddress }}</h6>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <ValidationObserver ref="sendMessageForm">
                        <div class="group">
                            <label for="" class="d-block mb-1">Receipant email <span
                                    class="text-danger require"></span></label>
                            <vue-tags-input @before-adding-tag="validateEmail" v-model="sendMessageData.emails"
                                :tags="emails" placeholder="Add/Remove Emails"
                                @tags-changed="newTags => emails = newTags" />
                        </div>
                        <div class="group">
                            <label for="" class="d-block mb-1">Mobile no <span
                                    class="text-danger require"></span></label>
                            <vue-tags-input @before-adding-tag="validatePhone" v-model="sendMessageData.phones"
                                :tags="phones" placeholder="Add/Remove Phones"
                                @tags-changed="newTags => phones = newTags" />
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
                                    <text-editor v-model="sendMessageData.message" placeholder="Enter message here...">
                                    </text-editor>
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
    import VueTagsInput from '@johmun/vue-tags-input';
    export default {
        components: {
            VueTagsInput,
        },
        props: {
            tab: String,
        },
        data() {
            return {
                sendMessageData: {
                    subject: '',
                    message: '',
                    emails: '',
                    phones: '',
                    send_email: 0,
                    send_sms: 0,
                    order_id: 0,
                },
                phones: [],
                emails: [],
                propertyAddress: ''
            }
        },
        methods: {
            emailCheckbox(event) {
                event.currentTarget.checked ? this.sendMessageData.send_email = 1 : this.sendMessageData.send_email = 0
            },
            setPropertyAddress(propertyAddress) {
                this.propertyAddress = propertyAddress
            },
            smsCheckbox(event) {
                event.currentTarget.checked ? this.sendMessageData.send_sms = 1 : this.sendMessageData.send_sms = 0
            },
            validatePhone(obj) {
                let phoneNo = obj.tag.text
                let validatePhoneNo = this.$boston.checkPhoneFormat(phoneNo)
                if (validatePhoneNo) {
                    obj.tag.text = this.$boston.formatPhoneNo(phoneNo)
                    obj.addTag()
                } else {
                    this.$toast.open({
                        message: "Invalid phone number!",
                        type: 'error',
                    });
                }
            },
            validateEmail(obj) {
                let email = obj.tag.text
                let formatedEmail = this.$boston.checkEmailFormat(email)
                if (formatedEmail) {
                    obj.tag.text = email
                    obj.addTag()
                } else {
                    this.$toast.open({
                        message: "Email format is wrong !",
                        type: 'error',
                    });
                }
            },
            setContactData(contactData, property, lender) {
                let vm = this
                this.emails = []
                this.phones = []
                this.sendMessageData.order_id = contactData.order_id
                let emails = (JSON.parse(contactData.contact_email)).email
                emails.map(function (value, key) {
                    vm.emails.push({ "text": value })
                })
                let phones = (JSON.parse(contactData.contact_email)).phone
                phones.map(function (value, key) {
                    vm.phones.push({ "text": value })
                })
                let lenderName = lender.name
                let propertyAddress = property.full_addr

                let formattedMessage = "Hello,<br/><br/> We have been assigned an appraisal through the <b>" + lenderName + "</b>. We need to schedule an appointment to complete an appraisal inspection of the subject property located at <strong>" + propertyAddress + "</strong>. <br/><br/>Please call our offices or email us at your earliest convenience. You can reach us at <b>617-440-7700</b> or via email at <b>orders@bostonappraisal.com</b>.<br/><br/> Thank you !";
                this.sendMessageData.message = formattedMessage;
            },
            sendMessage() {
                console.log(this.tab);
                this.$refs.sendMessageForm.validate().then((status) => {
                    if (status) {
                        if (this.emails.length == 0 || this.phones.length == 0) {
                            this.$toast.open({
                                message: "No email or phone number found",
                                type: 'error',
                            });
                            return false;
                        }
                        if (this.sendMessageData.send_email == 0 && this.sendMessageData.send_sms == 0) {
                            this.$toast.open({
                                message: "Please select atleast one method (Email or SMS)",
                                type: 'error',
                            });
                            return false;
                        }
                        this.$boston.post('send-message', { 'data': this.sendMessageData, 'emails': this.emails, 'phones': this.phones, 'filter': this.tab })
                            .then(res => {
                                console.log(res)
                                this.$bvModal.hide('send-message')
                                this.$root.$emit('wk_flow_toast', res)
                                this.$root.$emit('order_update', res.order)
                                this.$root.$emit('filter_update', res.filterValue)
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
