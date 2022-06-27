<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Issues/ Queries/ Tickets</p>
      <a @click="isIssueModal = true" class="d-inline-flex edit add-call align-items-center fw-bold cursor-pointer">Add issue</a>
    </div>
    <div class="box-body">
      <div class="queries-row" >
<!--        <div class="queries-box position-relative pending">-->
<!--          <span class="badges pending-badges">Pending</span>-->
<!--          <p class="text-gray text-end mgb-12">Today 12:10am</p>-->
<!--          <p class="text-light-black">He made payment but didnt get confirmation yet</p>-->
<!--          <div class="d-flex justify-content-between mgb-12">-->
<!--            <a href="#" class="text-gray mb-0 underline">Assigned to : <span class="text-light-black text-600">Technical team</span></a>-->
<!--            <a href="#" class="share-box">-->
<!--              <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>-->
<!--            </a>-->
<!--          </div>-->
<!--        </div>-->
<!--        <div class="queries-box position-relative pending" >-->
<!--          <span class="badges pending-badges">Pending</span>-->
<!--          <p class="text-gray text-end mgb-12">Today 12:10am</p>-->
<!--          <p class="text-light-black">He made payment but didnt get confirmation yet</p>-->
<!--          <div class="d-flex justify-content-between mgb-12">-->
<!--            <a href="#" class="text-gray mb-0">Assigned to : <span class="text-light-black text-600">Technical team</span></a>-->
<!--            <a href="#" class="share-box">-->
<!--              <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>-->
<!--            </a>-->
<!--          </div>-->
<!--        </div>-->
        <div class="queries-box position-relative solved">
          <span class="badges solved-badges">Pending</span>
          <p class="text-gray text-end mgb-12">Today 12:10am</p>
          <p class="text-light-black">He made payment but didnt get confirmation yet</p>
          <div class="d-flex justify-content-between mgb-12">
            <a href="#" class="text-gray mb-0">Assigned to : <span class="text-light-black text-600">Technical team</span></a>
            <a href="#" class="share-box">
              <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
            </a>
          </div>
          <div class="solution">
            <p class="mb-1 fs-14 ">Solution:</p>
            <p class="mb-0 fs-14">
                Amar sonar bangla ami tomai valobashi.
              Chirodin tomar akash tomar batash amar prane
              bajai bashi sonar bangla ami tomai valobashi.
            </p>
          </div>
        </div>
      </div>
    </div>
     <!-- modal -->
      <add-issue :showIssueModal="isIssueModal" :orderId="this.id"></add-issue>
<!--     <b-modal id="issue-info" class="brrower-modal" size="lg" title="Add Issue">-->
<!--        <div class="modal-body brrower-modal-body">-->
<!--          <div class="row">-->
<!--            <div class="col-12">-->
<!--              <div class="group">-->
<!--                <label for="" class="d-block mb-2 dashboard-label">Subject name</label>-->
<!--                <input type="text"  class="dashboard-input w-100">-->
<!--              </div>-->
<!--               <div class="group">-->
<!--                    <label for="client-type" class="d-block mb-2 dashboard-label">Client type <span-->
<!--                                class="text-danger require"></span></label>-->
<!--                    <div class="position-relative">-->
<!--                        <select name="client_type" id="client-type" class="dashboard-input w-100">-->
<!--                            <option value="">Select a type</option>-->
<!--                            <option value="amc" selected>Amc</option>-->
<!--                            <option value="lender">Lender</option>-->
<!--                        </select>-->
<!--                        <span class="icon-arrow-down bottom-arrow-icon"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="group">-->
<!--                  <label class="d-block mb-2 dashboard-label address-label">Queries or Issues</label>-->
<!--                  <textarea name="address" class="dashboard-textarea w-100" cols="30"-->
<!--                            rows="2"></textarea>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      <div slot="modal-footer mgt-44">-->
<!--        <button class="button button-transparent">Close</button>-->
<!--        <button class="button button-primary">Save</button>-->
<!--      </div>-->
<!--    </b-modal>-->
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
    }),
    created() {
        let order = this.order;
        this.fetchData(order);
        this.$root.$on('update_add_issue_modal', () => {
            console.log('hello from modal false')
            this.isIssueModal = false
        })
        this.$root.$on('issue_modal_update', (res) => {
            this.isIssueModal = false
            console.log('hello from modal update')
            this.fetchData(res);
        });
    },
    methods: {
        fetchData(order) {
            this.orderData = order
            console.log(order)
            this.id = this.orderData.id
            this.logs = !_.isEmpty(this.orderData.call_log) ? this.orderData.call_log : []
        },

    }
}
</script>
