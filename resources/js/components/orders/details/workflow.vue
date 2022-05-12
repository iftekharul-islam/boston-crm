<template>
  <div class="order-details__left col-md-8">
    Workflow
    <div class="order-details-box bg-white h-100">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Workflow</p>
        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
      </div>
      <div class="box-body">
        <div class="workflow-content">
          step list
          <div class="list">
            <div class="item complete">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item current">
              <span class="ball"><img src="/img/current.png" alt="current step boston"></span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
              <p class="mb-0">Order Creation</p>
            </div>
            <div class="item">
                                    <span class="ball">
                                        <img src="/img/current.png" alt="current step boston">
                                    </span>
              <p class="mb-0">Order Creation</p>
            </div>
          </div>
          step item
          <div class="step-item pe-3">
            Inspection
            <div class="inspection-item">
              <div class="top-bar">
                <button class="item active">Assign</button>
                <button class="item">Writing complete?</button>
                <button class="item">Add note</button>
              </div>
              <div class="item-body">
                <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Writer</label>
                  <div class="right-scedule w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                <div class="mgb-32">
                  <label for="" class="mb-2 text-light-black d-inline-block">Writer</label>
                  <div class="right-scedule w-100 position-relative">
                    <select name="" id="" class="w-100 dashboard-input">
                      <option value="">Hello</option>
                      <option value="">Hello</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
                <div class="text-end">
                  <button class="button button-primary px-5">Save</button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data(){
      return{

      }
    }
  }
</script>
