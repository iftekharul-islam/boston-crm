<template>
  <div class="order-creation-item step-items">
    <div class="group">
      <p class="text-light-black mgb-12">Created by</p>
      <p class="mb-0 text-light-black fw-bold">{{ order.user.name }}</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Create time & date</p>
      <p class="mb-0 text-light-black fw-bold">{{ order.created_at }}</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Received Date</p>
      <p class="mb-0 text-light-black fw-bold">{{ order.received_date }}</p>
    </div>
    <div class="group">
      <p class="text-light-black mgb-12">Due date</p>
      <p class="mb-0 text-light-black fw-bold">{{ order.due_date }}</p>
    </div>
  </div>
</template>
<script>
export default {
  name: 'OrderCreate',
  props: {
    order: []
  },
  data: () => ({})
}
</script>
