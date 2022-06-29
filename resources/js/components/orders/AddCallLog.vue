<template>
    <ValidationObserver ref="addCallLogForm">
        <!-- modal -->
        <b-modal id="add-call-log" class="brrower-modal" size="md" title="Add Call Log" no-close-on-backdrop>
            <div class="modal-body brrower-modal-body">
                <div class="row">
                    <div class="col-12">
                        <ValidationProvider class="d-block group" name="Assign to" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Assign To</label>
                                <m-select :options="users" object item-text="name" item-value="id" v-model="assignTo"></m-select>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="col-12 mt-2">
                        <ValidationProvider class="d-block group" name="Message" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Message</label>
                                <textarea v-model="message" class="dashboard-input w-100" style="min-height: 100px"></textarea>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="col-12">
                        <div class="checkbox-group review-check mgt-20">
                            <input type="checkbox" class="checkbox-input check-data" v-model="isCompleted">
                            <label for="" class="checkbox-label text-capitalize">Completed </label>
                        </div>
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
        'orderId', 'showModal', 'users'
    ],
    data: () => ({
        id: '',
        message: '',
        assignTo: '',
        isCompleted: null
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
                        message: this.message,
                        caller_id: this.assignTo,
                        status: this.isCompleted
                    }
                    axios.post('call-log/' + this.id, data)
                        .then(res => {
                            if (res.data.error) {
                                this.$root.$emit('wk_flow_toast', res.data)
                            } else {
                                this.message = ''
                                this.assignTo = ''
                                this.isCompleted = null
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
