<template>
    <b-modal id="add-status" size="md" title="Add Status">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <ValidationObserver ref="addStatusForm">
                        <ValidationProvider class="group d-block" name="Status" rules="required"
                            v-slot="{ errors }">
                            <div :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Status<span
                                        class="text-danger require"></span></label>
                                <input type="text" class="dashboard-input w-100" v-model="status">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button type="button" variant="secondary" @click="$bvModal.hide('add-status')">Close</b-button>
            <b-button type="button" variant="primary" @click="saveStatus">Save</b-button>
        </div>
    </b-modal>
</template>
<script>
    export default {
        name: 'add-Status',
        data: () => ({
            status: ''
        }),
        methods: {
            saveStatus() {
                this.$refs.addStatusForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('save-status', {'status': this.status})
                            .then(res => {
                                this.$root.$emit('status_res', res.data)
                                this.$root.$emit('toast_msg', res)
                                this.$bvModal.hide('add-status')
                                this.status = ''
                            })
                            .catch(err => {
                                console.error(err)
                            })
                    }
                })
            }
        },
    }
</script>
