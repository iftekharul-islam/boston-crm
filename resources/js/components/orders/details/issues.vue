<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Issues/ Queries/ Tickets</p>
      <a @click.prevent="isIssueModal = true" class="d-inline-flex edit add-call align-items-center fw-bold cursor-pointer">Add issue</a>
    </div>
        <div class="box-body" v-if="tickets.length">
      <div class="queries-row" >
        <div v-for="(ticket, index) in tickets" class="queries-box position-relative" :class="{ 'solved':  ticket.status == 1 , 'pending': ticket.status == 0 }" :key="index">
              <span class="badges solved-badges" v-if="ticket.status == 1">Solved</span>
              <span class="badges pending-badges" v-else>Pending</span>
              <p class="text-gray text-end mgb-12">{{ ticket.created_at | momentTime }}</p>
              <div class="issue">
                  <p class="text-light-black">{{ ticket.issue }}</p>
              </div>
              <div class="d-flex justify-content-between mgb-12">
                  <p class="text-gray mb-0" v-if="ticket.assignee">Assigned to : <span class="text-light-black text-600">{{ ticket.assignee.name }}</span></p>
                  <a href="#" class="share-box" @click.prevent="showUpdateModal(ticket)">
                      <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
                  </a>
              </div>
              <div class="solution" v-if="ticket.solution">
                  <p class="mb-1 fs-14 ">Solution:</p>
                  <p class="mb-0 fs-14">{{ ticket.solution }}</p>
              </div>
        </div>
      </div>
    </div>
      <div class="text-center mt-3 mb-3" v-else>
          No Issues/ Queries added yet !
      </div>
     <!-- modal -->
    <add-issue :showIssueModal="isIssueModal" :orderId="this.id"></add-issue>
    <ValidationObserver ref="addIssueSolutionForm">
          <!-- modal -->
          <b-modal id="add-issue-solution-modal" class="brrower-modal" size="md" title="Add Issue" no-close-on-backdrop>
              <div class="modal-body brrower-modal-body">
                  <div class="row">
                      <div class="col-12">
                          <ValidationProvider class="d-block group" name="Subject name" rules="required" v-slot="{ errors }">
                              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                  <label for="" class="d-block mb-2 dashboard-label">Subject name</label>
                                  <input type="text" v-model="ticket.subject" class="dashboard-input w-100">
                                  <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                              </div>
                          </ValidationProvider>
                          <ValidationProvider class="d-block group" name="Queries or Issues" rules="required" v-slot="{ errors }">
                              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                  <label for="" class="d-block mb-2 dashboard-label">Queries or Issues</label>
                                  <b-form-textarea v-model="ticket.issue" placeholder="Enter issue..." rows="2"
                                                   cols="5">
                                  </b-form-textarea>
                                  <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                              </div>
                          </ValidationProvider>
                          <ValidationProvider class="d-block group" name="Solution" rules="required" v-slot="{ errors }">
                              <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                  <label for="" class="d-block mb-2 dashboard-label">Solution</label>
                                  <b-form-textarea v-model="ticket.solution" placeholder="Enter Solution..." rows="2"
                                                   cols="5">
                                  </b-form-textarea>
                                  <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                              </div>
                          </ValidationProvider>
                      </div>
                  </div>
              </div>
              <div slot="modal-footer" class="mgt-44">
                  <button class="button button-transparent" @click="$bvModal.hide('add-issue-solution-modal')">Close</button>
                  <button class="button button-primary" @click="updateIssue">Post</button>
              </div>
          </b-modal>
      </ValidationObserver>
  </div>
</template>
<script>
export default {
    name: 'issues',
    props: [
        'order',
    ],
    data: () => ({
        orderData: {},
        isIssueModal: false,
        issues: [],
        id: null,
        tickets: [],
        ticket: {
            id: '',
            subject: '',
            issue: '',
            solution: ''
        }
    }),
    created() {
        let order = this.order;
        this.fetchData(order);
        this.$root.$on('update_add_issue_modal', () => {
            this.isIssueModal = false
        })
        this.$root.$on('issue_modal_update', (res) => {
            this.isIssueModal = false
            this.fetchData(res);
        });
    },
    methods: {
        showUpdateModal(object) {
            this.ticket.id = object.id
            this.ticket.subject = object.subject
            this.ticket.issue = object.issue
            this.ticket.solution = object.solution
            this.$bvModal.show('add-issue-solution-modal')
        },
        updateIssue() {
            this.$refs.addIssueSolutionForm.validate().then((status) => {
                if (status) {
                    let data = {
                        subject: this.ticket.subject,
                        issue: this.ticket.issue,
                        solution: this.ticket.solution
                    }
                    axios.post('update-issue/' + this.ticket.id, data)
                        .then(res => {
                            if (this.error) {
                                this.$root.$emit('wk_flow_toast', res.data)
                            } else {
                                this.$bvModal.hide('add-issue-solution-modal')
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
        fetchData(order) {
            this.orderData = order
            this.id = this.orderData.id
            this.tickets = !_.isEmpty(this.orderData.tickets) ? this.orderData.tickets : []
        },

    }
}
</script>
