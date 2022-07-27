<template>
    <div>
        <b-modal id="add-status" size="md" title="Add Status">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <button @click="addStatus = true" class="btn btn-primary p-2 m-2" type="button">+ Add
                            Status</button>
                    </div>
                    <div class="col-md-12" v-if="addStatus">
                        <ValidationObserver ref="addStatusForm">
                            <ValidationProvider class="group d-block" name="Status" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Status<span
                                            class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100" placeholder="Enter status name"
                                        v-model="status">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </ValidationObserver>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12" v-for="status,index in statuses">
                            <div class="row m-2">
                                <div class="col-md-10">
                                    <p class="text-bold text-xl">{{ status.status }}</p>
                                </div>
                                <div class="col-md-2">
                                    <a class="edit-btn"><span @click="editStatus(status)" class="icon-edit"><span
                                                class="path1"></span><span class="path2"></span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button type="button" variant="secondary" @click="$bvModal.hide('add-status')">Close</b-button>
                <b-button type="button" variant="primary" @click="saveStatus">Save</b-button>
            </div>
        </b-modal>
        <b-modal id="edit-status" size="md" title="Edit Status">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <ValidationObserver ref="editStatusForm">
                            <ValidationProvider class="group d-block" name="Status" rules="required"
                                v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Status<span
                                            class="text-danger require"></span></label>
                                    <input type="text" class="dashboard-input w-100" placeholder="Enter status name"
                                        v-model="editStatusName">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button type="button" variant="secondary" @click="$bvModal.hide('edit-status')">Close</b-button>
                <b-button type="button" variant="primary" @click="updateStatus">Save</b-button>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        name: 'add-Status',
        props: {
            statuses: [],
        },
        data: () => ({
            status: '',
            addStatus: false,
            editStatusName: '',
            editStatusId: ''
        }),
        methods: {
            saveStatus() {
                this.$refs.addStatusForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('save-status', { 'status': this.status })
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
            },
            editStatus(status) {
                this.$bvModal.show('edit-status')
                this.editStatusName = status.status
                this.editStatusId = status.id
            },
            updateStatus() {
                this.$refs.editStatusForm.validate().then((status) => {
                    if (status) {
                        this.$boston.post('update-status', { 'status': this.editStatusName,'id': this.editStatusId })
                            .then(res => {
                                this.$root.$emit('status_res', res.data)
                                this.$root.$emit('toast_msg', res)
                                this.$bvModal.hide('edit-status')
                                this.editStatusName = ''
                                this.editStatusId = ''
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
