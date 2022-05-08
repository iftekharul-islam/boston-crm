<template>
  <div>
    <div class="row mgb-32">
      <div class="col-md-8 ">
        <div class="form-box">
          <h4 class="box-header mb-3">Appraisal details</h4>

          <div class="d-flex justify-content-between w-100">
            <div class="left max-w-424 w-100 me-3">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Client order no <span
                    class="text-danger require"></span></label>
                <input type="text" class="dashboard-input w-100" v-model="clientOrderNo">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Loan no</label>
                <input type="text" class="dashboard-input w-100" v-model="loanNo">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Loan type </label>
                <div class="position-relative">
                  <select name="" id="" class="dashboard-input w-100" v-model="loanType">
                    <option value="">Loan</option>
                    <option value="">Loan</option>
                    <option value="">Loan</option>
                  </select>
                  <span class="icon-arrow-down bottom-arrow-icon"></span>
                </div>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Received date <span
                    class="text-danger require"></span></label>
                <div class="position-relative">
                  <input type="date" class="dashboard-input w-100" v-model="receiveDate">
                  <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                      class="path3"></span><span class="path4"></span><span class="path5"></span><span
                      class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                </div>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Technology fee <span
                    class="text-danger require"></span></label>
                <input type="text" class="dashboard-input w-100" v-model="technologyFee">
              </div>
            </div>
            <div class="right max-w-424 w-100">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">System order </label>
                <input type="text" class="dashboard-input w-100" v-model="systemOrder">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">FHA case no</label>
                <input type="text" class="dashboard-input w-100" v-model="fhaCaseNo">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                    class="text-danger require"></span></label>
                <div class="position-relative">
                  <select name="" id="" class="dashboard-input w-100" v-model="appraiserName">
                    <option value="">Loan</option>
                    <option value="">Loan</option>
                    <option value="">Loan</option>
                  </select>
                  <span class="icon-arrow-down bottom-arrow-icon"></span>
                </div>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Due date <span
                    class="text-danger require"></span></label>
                <div class="position-relative">
                  <input type="date" class="dashboard-input w-100" v-model="dueDate">
                  <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                      class="path3"></span><span class="path4"></span><span class="path5"></span><span
                      class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-md-4">
        <div class="form-box h-100 d-flex flex-column">
          <div>
            <h4 class="box-header mb-3">Appraisal details</h4>
            <div class="row">
              <div class="col-6">
                <div class="group">
                  <label for="" class="d-block mb-2 dashboard-label">Appraiser type <span
                      class="text-danger require"></span></label>
                  <div class="position-relative">
                    <select name="" id="" class="dashboard-input w-100" v-model="appraiserType">
                      <option value="">Loan</option>
                      <option value="">Loan</option>
                      <option value="">Loan</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="group">
                  <label for="" class="d-block mb-2 dashboard-label">Fee </label>
                  <input type="text" class="dashboard-input w-100" v-model="fee">
                </div>
              </div>
              <div class="col-12 text-end mt-4">
                <button class="add-more" @click="addFee"><span class="icon-plus"></span> Add more</button>
              </div>
            </div>
          </div>
          <div class="mt-auto">
            <label for="" class="d-block mb-2 dashboard-label">Note <span class="text-danger require"></span></label>
            <textarea name="" id="" rows="7" class="dashboard-textarea w-100" v-model="note"></textarea>
            <h3 class="text-light-black fw-bold mgt-40">Total fee : <span>$1200</span></h3>
          </div>
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-box h-100">
          <h4 class="box-header mb-3">Client info</h4>
          <div class="group">
            <label for="" class="d-block mb-2 dashboard-label">AMC name <span
                class="text-danger require"></span></label>
            <div class="dropdown order-dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                      data-bs-toggle="dropdown" aria-expanded="false">
                Choose an AMC
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#"><span class="icon-plus me-1"></span> Add new</a></li>
                <li><a class="dropdown-item" href="#">AMC</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </div>
          </div>
          <div class="group">
            <label for="" class="d-block mb-2 dashboard-label">Lender <span class="text-danger require"></span></label>
            <div class="dropdown order-dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                      data-bs-toggle="dropdown" aria-expanded="false">
                Choose an AMC
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#"><span class="icon-plus me-1"></span> Add new</a></li>
                <li><a class="dropdown-item" href="#">AMC</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </div>
          </div>
        </div>

      </div>
      <div class="col-md-8 ">
        <div class="form-box">
          <h4 class="box-header mb-3">Property info</h4>
          <div class="d-flex justify-content-between w-100">
            <div class="left max-w-424 w-100 me-3">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Search address <span
                    class="text-danger require"></span></label>
                <input type="text" class="dashboard-input w-100" v-model="searchAddress">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">State name <span class="text-danger require"></span>
                </label>
                <input type="text" class="dashboard-input w-100" v-model="state">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">City name <span class="text-danger require"></span>
                </label>
                <input type="text" class="dashboard-input w-100" v-model="city">
              </div>
            </div>

            <div class="right max-w-424 w-100">
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Street name <span class="text-danger require"></span>
                </label>
                <input type="text" class="dashboard-input w-100">
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Zip code <span
                    class="text-danger require"></span></label>
                <div class="position-relative">
                  <select name="" id="" class="dashboard-input w-100">
                    <option value="">Loan</option>
                    <option value="">Loan</option>
                    <option value="">Loan</option>
                  </select>
                  <span class="icon-arrow-down bottom-arrow-icon"></span>
                </div>
              </div>
              <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">County <span class="text-danger require"></span>
                </label>
                <input type="text" class="dashboard-input w-100">
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
  name: "Step1",
  data() {
    return {
      stepActive: false,
      clientOrderNo: '',
      loanNo: '',
      loanType: '',
      receiveDate: '',
      technologyFee: '',
      systemOrder: '',
      fhaCaseNo: '',
      appraiserName: '',
      dueDate: '',
      appraiserType: '',
      fee: [],
      note: '',
      searchAddress: '',
      state: '',
      city: ''
    }
  },
  methods: {
    stepChangeActive() {
      this.$emit('step-change-active', this.stepActive);
    },
    addFee() {

    }
  }
}
</script>

<style scoped>

</style>
