<template>
  <div class="revission-modal" v-if="revissionModal">
    <div class="revission-content position-relative">
      <div class="header bg-gray d-flex align-items-center justify-content-between">
        <p class="mb-0 fs-20 fw-bold text-white">Revission</p>
        <span class="cursor-pointer" @click="revission()">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 17L17 1" stroke="white" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M17 17L1 1" stroke="white" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    </svg>

                </span>
      </div>
      <div class="revission-body">
        <!-- add button -->
        <div class="revission-add text-end mb-3">
          <button v-if="!addRevission" @click="revissionAdd()"
                  class="button button-primary py-2 h-40 flex-center d-inline-flex">Add revission
          </button>
        </div>
        <!-- add revission form -->
        <div v-if="addRevission" class="add-revission bg-white mgb-12">
          <p>Add revission</p>
          <div class="mgb-32 group">
            <p>Date & time</p>
            <div class="position-relative">
              <input type="date" class="dashboard-input w-100 gray-border">
              <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                  class="path3"></span><span class="path4"></span><span class="path5"></span><span
                  class="path6"></span><span class="path7"></span><span class="path8"></span></span>
            </div>
          </div>
          <div>
            <p>Revission details</p>
            <textarea name="" id="" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
          </div>
          <div class="text-end">
            <button @click="revissionAdd()" class="button button-transparent px-5 h-40 flex-center">Close</button>
            <button class="button button-primary px-5 h-40 flex-center d-inline-flex">Add</button>
          </div>
        </div>
        <!-- revission card -->
        <div class="revission-card bg-white position-relative">
          <div class="revission-card-top">
            <div class="revission-card-header d-flex">
              <div class="revission-name me-3">
                <p class="mb-0 fs-20 fw-bold">Khadimul islam</p>
                <p class="mb-0">Today, 3:45 pm</p>
              </div>
              <div class="marked">
                <a href="" class="open fs-14">Open</a>
                <a href="" class="mark-delivery fs-14">Mark as delivered</a>
              </div>
              <div class="button-box ms-auto">
                <button class="action-btn mgr-12"><span class="icon-trash"><span class="path1"></span><span
                    class="path2"></span><span class="path3"></span><span class="path4"></span></span></button>
                <button @click="editRevission()" class="action-btn"><span class="icon-edit"><span
                    class="path1"></span><span class="path2"></span></span></button>
              </div>
            </div>
            <p class="mgb-12">Revission details</p>
            <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
              in laying out print, graphic or web designs.</p>
          </div>
          <!-- solution -->
          <div class="solution">
            <div class="solution-header d-flex align-items-start mb-2">
              <div>
                <p class="mgb-12">Solution</p>
                <p class="mb-0">Today, 3:45 pm</p>
              </div>
              <div class="button-box ms-auto">
                <button class="action-btn"><span class="icon-edit"><span class="path1"></span><span
                    class="path2"></span></span></button>
              </div>
            </div>
            <p class="fw-bold mgb-20">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out
              print, graphic or web designs. The passage is attributed
              to an unknown</p>
            <div class="d-flex">
              <div class="col-6">
                <p class="mgb-10">Delivered by</p>
                <p class="fw-bold">Khadimul islam</p>
              </div>
              <div class="col-6">
                <p class="mgb-10">Delivered by</p>
                <p class="fw-bold">Khadimul islam</p>
              </div>
            </div>
          </div>
          <!-- add solution button -->
          <div v-if="!addSolution" class="text-end mgt-28">
            <button @click="solutionAdd()" class="button button-transparent primary-text p-0"><span
                class="icon-plus primary-text"></span> <span class="ms-2 primary-text">Add solution</span></button>
          </div>
          <!-- add solution box -->
          <div v-if="addSolution" class="add-solution-box mgt-28">
            <p class="mgb-8">Add solution</p>
            <textarea name="" id="" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
            <div class="d-flex justify-content-end mgt-12">
              <button @click="solutionAdd()" class="close-solution bg-white fs-14">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 9L9 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"/>
                  <path d="M9 9L1 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"/>
                </svg>
                Close
              </button>
              <button class="add-solution bg-white fs-14">
                <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                      d="M4.29515 8.6053C4.05503 8.6053 3.82691 8.50925 3.65883 8.34117L0.261131 4.94347C-0.0870435 4.5953 -0.0870435 4.01901 0.261131 3.67084C0.609305 3.32266 1.18559 3.32266 1.53377 3.67084L4.29515 6.43222L10.4662 0.261131C10.8144 -0.0870435 11.3907 -0.0870435 11.7389 0.261131C12.087 0.609305 12.087 1.18559 11.7389 1.53377L4.93147 8.34117C4.76338 8.50925 4.53527 8.6053 4.29515 8.6053Z"
                      fill="#19B7A2"/>
                </svg>
                Add
              </button>
            </div>
          </div>
          <!-- edit revission -->
          <div v-if="revissionEdit" class="edit-revission">
            <p class="mgb-22 fs-20 fw-bold">Mark as delivered</p>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Completed by <span class="require"></span> </label>
              <div class="position-relative">
                <select name="" id="" class="dashboard-input gray-border w-100">
                  <option value="">Select one</option>
                  <option value="">Loan</option>
                  <option value="">Loan</option>
                </select>
                <span class="icon-arrow-down bottom-arrow-icon"></span>
              </div>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Delivered by <span class="require"></span> </label>
              <div class="position-relative">
                <select name="" id="" class="dashboard-input gray-border w-100">
                  <option value="">Select one</option>
                  <option value="">Loan</option>
                  <option value="">Loan</option>
                </select>
                <span class="icon-arrow-down bottom-arrow-icon"></span>
              </div>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Delivered by <span class="require"></span> </label>
              <div class="position-relative">
                <input type="date" class="dashboard-input w-100 gray-border">
                <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                    class="path3"></span><span class="path4"></span><span class="path5"></span><span
                    class="path6"></span><span class="path7"></span><span class="path8"></span></span>
              </div>
            </div>
            <div class="group">
              <label for="" class="mb-2 text-light-black d-inline-block">Add solution <span
                  class="require"></span></label>
              <div class="preparation-input w-100 position-relative">
                <textarea name="" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
              </div>
            </div>
            <div class="text-end">
              <button @click="editRevission()" class="button button-transparent px-5 h-40 flex-center">Close</button>
              <button class="button button-primary px-5 h-40 flex-center d-inline-flex">Mark</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
<script>
export default {
  name: 'Revision',
  data: () => ({
    revissionModal: true,
    addRevission: true,
    addSolution: true,
    revissionEdit: true
  }),
  methods:{
    revission() {
      this.revissionModal = !this.revissionModal
    },
    revissionAdd() {
      this.addRevission = !this.addRevission;
    },
    solutionAdd() {
      this.addSolution = !this.addSolution
    },
    editRevission() {
      this.revissionEdit = !this.revissionEdit
    }
  }
}
</script>
