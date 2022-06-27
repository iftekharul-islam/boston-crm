<template>
    <ValidationObserver ref="addCallLogForm">
        <!-- modal -->
        <b-modal id="add-call-log" class="brrower-modal" size="md" title="Add Call Log" no-close-on-backdrop>
            <div class="modal-body brrower-modal-body">
                <div class="row">
                    <div class="col-12">
                        <ValidationProvider class="d-block group" name="Message" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Message<span
                                    class="text-danger require"></span></label>
                                <textarea v-model="message" class="dashboard-input w-100" style="min-height: 100px"></textarea>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
            </div>
            <div slot="modal-footer" class="mgt-44">
                <button class="button button-transparent" @click="hideModel">Close</button>
                <button class="button button-primary" @click="addLog">Save</button>
            </div>
        </b-modal>
    </ValidationObserver>
</template>

<script>
export default {
    props: [
        'orderId', 'showModal'
    ],
    data: () => ({
        id: '',
        message: '',
    }),
    watch: {
        showModal(newValue, oldValue) {
            if (newValue === true) {
                this.$bvModal.show('add-call-log')
            } else {
                this.$bvModal.hide('add-call-log')
            }
        }
    },
    created() {
        this.id = this.orderId;
    },
    methods: {
        hideModel() {
            this.$bvModal.hide('add-call-log')
            this.$root.$emit('update_modal')

        },
        addLog(){
            this.$refs.addCallLogForm.validate().then((status) => {
                if (status) {
                    let data = {
                        message: this.message
                    }
                    axios.post('call-log/' + this.id, data)
                        .then(res => {
                            if (this.error) {
                                this.$root.$emit('wk_flow_toast', res.data)
                            } else {
                                this.$root.$emit('call_log_update', res.data.data)
                                this.$root.$emit('wk_update', res.data.data)
                                this.$root.$emit('wk_flow_menu', res.data.data)
                                this.$root.$emit('wk_flow_toast', res.data)
                                this.$bvModal.hide('add-call-log')
                                this.message = ''
                            }
                        }).catch(err => {
                        console.log(err)
                    })
                }
            })
        },
    }
}

</script>
