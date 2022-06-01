<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Notes</p>
    </div>
    <div class="box-body">
      <div class="note-chat">
<!--        item chat-->
        <div class="chat-item">
          <div class="chat-name d-flex align-items-center">
            <img src="/img/dummy-profile.png" alt="boston chat image" class="img-fluid">
            <div class="ms-3">
              <p class="text-600 mb-1">{{ order.user.name }}</p>
              <span class="text-gray">{{ order.user_role }}</span>
            </div>
          </div>
<!--  chat-->
          <div class="d-inline-block message">
            <p class="mb-0 ">{{ order.provider_service.note }}</p>
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

        }),
    }
</script>
