<template>
  <div class="order-details-box ">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Notes</p>
    </div>
    <div class="box-body bg-white">
      <div class="note-chat">

        <div class="chat-item" v-for="noteItem, ni in notes" :key="noteItem.key + ni">
          <div class="chat-name d-flex align-items-center">
            <img src="/img/dummy-profile.png" alt="boston chat image" class="img-fluid">
            <div class="ms-3">
              <p class="text-600 mb-1">{{ noteItem.user ? noteItem.user.name : '-' }}</p>
              <span class="text-gray">{{ noteItem.user ? noteItem.user.email : '-' }}</span>
            </div>
          </div>
          <div class="d-inline-block message">
            <small>{{ noteItem.title }}</small>
            <p class="mb-0 ">{{ noteItem.note }}</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>
<script>
    export default{
        props:{
            order: []
        },
        data:() => ({
          orderData: [],
          notes: []
        }),
        created() {
            this.initNotes(this.order);
            this.$root.$on('wk_update', (res) => {
              this.initNotes(res);
            });
        },
        methods: {
          initNotes(order) {
              this.orderData = order;
              this.notes.push({
                  key: 'provided_service',
                  title: "Provided Services",
                  note: order.provider_service.note,
                  user: order.user
              });

              if ( order.report ) {
                this.notes.push({
                    key: 'inspection_schedule',
                    title: "Inspection Schedule",
                    note: order.inspection.note,
                    user: order.inspection.create_by
                });
              }

              if ( order.initial_review ) {
                this.notes.push({
                    key: 'initial_review',
                    title: "Initial Review",
                    note: order.initial_review.note,
                    user: order.initial_review.create_by
                });
              }

              if ( order.analysis ) {
                  this.notes.push({
                      key: 'analysis',
                      title: "Report Analysys",
                      note: order.analysis.note,
                      user: order.analysis.update_by
                  });
                  if (order.analysis.rewrite_note) {
                    this.notes.push({
                        key: 'analysis_rewrite',
                        title: "Report Analysys Rewrite",
                        note: order.analysis.rewrite_note,
                        user: order.analysis.update_by
                    });
                  }
              }
            
            if (order.report_rewrite) {
                this.notes.push({
                      key: 'report_rewrite',
                      title: "Report Rewrites",
                      note: order.report_rewrite.note,
                      user: order.report_rewrite.update_by
                  });
              }

              if (order.quality_assurance) {
                this.notes.push({
                      key: 'quality_assurance',
                      title: "Quality Assurance",
                      note: order.quality_assurance.note,
                      user: order.quality_assurance.updated_by
                  });
              }
          }
        }
    }
</script>
