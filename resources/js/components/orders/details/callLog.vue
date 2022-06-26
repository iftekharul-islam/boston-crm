<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Call log</p>
        <a @click="isModal = true" class="d-inline-flex edit add-call align-items-center fw-bold">Add call log</a>
    </div>
    <div class="box-body">
      <div class="col-log">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr>
              <th scope="col">SL</th>
              <th scope="col">Caller name</th>
              <th scope="col">Call date & time</th>
              <th scope="col">Message</th>
              <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(log, index) in logs" :key="index">
              <td>{{ index + 1}}.</td>
              <td>{{ log.caller.name }}</td>
              <td>{{ log.created_at | dateTime }}</td>
              <td>{{ log.message }}</td>
              <td>
                <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
          <add-call-log :showModal="isModal" :orderId="this.id" @click.native.stop></add-call-log>
  </div>
</template>
<script>
export default {
    name: 'callLog',
    props: {
        order: [],
    },
    data: () => ({
        isModal: false,
        logs: [],
        id: null,
        message: null
    }),
    created() {
        let order = this.order;
        this.inspectionData(order);
        this.$root.$on('update_modal', () => {
            this.isModal = false
        })
        this.$root.$on('call_log_update', (res) => {
            this.isModal = false
            this.inspectionData(res);
        });
    },
    methods: {
        inspectionData(order) {
            this.orderData = order
            this.id = this.orderData.id
            this.logs = !_.isEmpty(this.orderData.call_log) ? this.orderData.call_log : []
            console.log(this.logs)
        },

    }
}
</script>
