<template>
  <div class="order-details__right col-md-4">
    <!-- History -->
    <div class="order-details-box bg-white h-100">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">History</p>

      </div>
      <div class="box-body">
        <p class="mb-3 text-light-black">Order Created by: <span class="text-600 text-light-black">Toushi</span></p>
        <template v-for="item, ai in history">
          <div class="fs-14 logItem" :key="ai">
            <div class="logby">
              <span>{{ item.user.name }}</span>
              <span>{{ item.created_at | momentTime }}</span>
            </div>
            <div class="logs">
              {{ item.history }}
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>


<script>

export default {
    props: ['order'],
    data: () => ({
        history: []
    }),
    created(){
      this.history = this.order.work_hisotry;

      this.$root.$on('wk_update', (res) => {
          this.history = res.work_hisotry;
      });
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
    top: 50%;
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
  .logItem:last-of-type::before {
    height: 0;
  }

</style>
