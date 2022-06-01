<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Activity log</p>
    </div>
    <div class="box-body">
      <template v-for="activityLog, ai in activityLogs">
        <div class="fs-14 logItem" :key="ai">
          <div class="logby">
            <span>{{ activityLog.user.name }}</span>
            <span>{{activityLog.created_at}}</span>
          </div>
          <div class="logs">
            {{ activityLog.activity_text }}
          </div>
        </div>
      </template>
    </div>
  </div>
</template>
<script>
  export default {
    props:{
      orderId: String,
      order: []
    },
    data(){
      return{
        activityLogs: ''
      }
    },
    created() {
      this.getActivityLog()
    },
    methods: {
      getActivityLog(){
        this.activityLogs = this.order.activity_log
      }
    }
  }
</script>

<style>

  .logItem {
    padding-bottom: 8px;
    padding-top: 8px;
    position: relative;
    padding-left: 15px;
  }
  
  .logItem .logby {
    font-size: 10px;
    font-weight: bold;
    color: rgb(43, 75, 216);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .logItem .logby span:nth-last-child(1) {
    color: #999;
  }
  .logItem::before{
    content: "";
    position: absolute;
    width: 1px;
    height: 100%;
    top: 0;
    left: 0;
    background: #999;
  }
  .logItem::after{
    content: "";
    position: absolute;
    width: 10px;
    height: 10px;
    left: -4px;
    top: 50%;
    background: #5de1b5;
    border-radius: 0.5rem;
  }

</style>
