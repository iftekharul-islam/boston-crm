<template>
    <ValidationObserver ref="addIssueForm">
        <!-- modal -->
        <b-modal id="add-issue-modal" class="brrower-modal" size="md" title="Add Issue" no-close-on-backdrop>
            <div class="modal-body brrower-modal-body">
                <div class="row">
                    <div class="col-12">
                        <ValidationProvider class="d-block group" name="Subject name" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Subject name</label>
                                <input type="text" v-model="subject" class="dashboard-input w-100">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <ValidationProvider class="d-block group" name="Queries or Issues" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Queries or Issues</label>
                                <input v-model="issue" class="dashboard-input w-100" style="min-height: 100px">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
            </div>
            <div slot="modal-footer" class="mgt-44">
                <button class="button button-transparent" @click="hideModel">Close</button>
                <button class="button button-primary" @click="addIssue">Save</button>
            </div>
        </b-modal>
    </ValidationObserver>
</template>

<script>
export default {
    props: [
        'orderId', 'showIssueModal'
    ],
    data: () => ({
        id: '',
        subject: '',
        issue: ''
    }),
    watch: {
        showIssueModal(newValue, oldValue) {
            if (newValue === true) {
                this.$bvModal.show('add-issue-modal')
            } else {
                this.$bvModal.hide('add-issue-modal')
            }
        }
    },
    created() {
        this.id = this.orderId;
    },
    methods: {
        hideModel() {
            console.log('hello')
            this.$bvModal.hide('add-issue-modal')
            this.$root.$emit('update_add_issue_modal')
        },
        addIssue(){
            this.$refs.addIssueForm.validate().then((status) => {
                if (status) {
                    let data = {
                        subject: this.subject,
                        issue: this.issue
                    }
                    axios.post('issue/' + this.id, data)
                        .then(res => {
                            if (this.error) {
                                this.$root.$emit('wk_flow_toast', res.data)
                            } else {
                                this.$root.$emit('issue_modal_update', res.data.data)
                                this.$root.$emit('wk_update', res.data.data)
                                this.$root.$emit('wk_flow_menu', res.data.data)
                                this.$root.$emit('wk_flow_toast', res.data)
                                this.$bvModal.hide('add-issue-modal')
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
