<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Activity log</p>
    </div>
    <div class="box-body">
      <template v-for="activityLog in activityLogs">
        <p class="fs-14 mgb-20">{{ activityLog.activity_text + ' - ' + activityLog.user.name + ' - ' + activityLog.created_at }}</p>
      </template>
    </div>
  </div>
</template>
<script>
  export default {
    props:{
      orderId: String
    },
    data(){
      return{
        activityLogs: '',
      }
    },
    created() {
      this.getActivityLog()
    },
    methods:{
      getActivityLog(){
        axios.get('get-activity-log/'+ this.orderId)
            .then(res => {
              this.activityLogs = res.data.activityLog
            }).catch(err => {
          console.log(err)
        })
      }
    }
  }
</script>
