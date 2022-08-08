<template>
    <ValidationObserver ref="addIssueForm">
        <!-- modal -->
        <b-modal id="add-issue-modal" class="brrower-modal" size="md" title="Add Issue" no-close-on-backdrop>
            <div class="modal-body brrower-modal-body">
                <div class="row">
                    <div class="col-12">
                        <ValidationProvider name="Subject name" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Subject name</label>
                                <input type="text" v-model="subject" class="dashboard-input w-100">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Assign To</label>
                            <m-select :options="users" object item-text="name" item-value="id" v-model="assignTo"></m-select>
                        </div>
                        <ValidationProvider class="d-block group" name="Queries or Issues" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Queries or Issues</label>
                                <b-form-textarea v-model="issue" placeholder="Enter issue..." rows="2"
                                                 cols="5">
                                </b-form-textarea>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
            </div>
            <div slot="modal-footer" class="mgt-44">
                <button class="button button-transparent" @click="hideModel">Close</button>
                <button class="button button-primary" @click="addIssue">Post</button>
            </div>
        </b-modal>
    </ValidationObserver>
</template>

<script>
 export default {
    props: [
        'orderId', 'showIssueModal', 'users'
    ],
    data: () => ({
        id: '',
        subject: '',
        issue: '',
        assignTo: ''
    }),
    watch: {
        showIssueModal(newValue, oldValue) {
            if (newValue === true) {
                this.subject = ''
                this.issue = ''
                this.assignTo = ''
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
            this.$bvModal.hide('add-issue-modal')
            this.$root.$emit('update_add_issue_modal')
        },
        addIssue(){
            this.$refs.addIssueForm.validate().then((status) => {
                if (status) {
                    let data = {
                        subject: this.subject,
                        issue: this.issue,
                        assignTo: this.assignTo
                    }
                    axios.post('issue/' + this.id, data)
                        .then(res => {
                            if (this.error) {
                                this.$root.$emit('wk_flow_toast', res.data)
                            } else {
                                this.$bvModal.hide('add-issue-modal')
                                this.$root.$emit('issue_modal_update', res.data.data)
                                this.$root.$emit('wk_update', res.data.data)
                                this.$root.$emit('wk_flow_menu', res.data.data)
                                this.$root.$emit('wk_flow_toast', res.data)
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
