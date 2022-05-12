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
            <h4 class="box-header mb-3">Provided services</h4>
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
    <div class="add-client__bottom d-flex justify-content-end  p-3">
      <button class="button button-discard me-3 d-flex align-items-center">Discard <span class="icon-close-circle ms-3"><span class="path1"></span><span class="path2"></span></span></button>
      <button class="button button-primary">
        Next
        <svg class="ms-4" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12.4291 13.82C12.2391 13.82 12.0491 13.75 11.8991 13.6C11.6091 13.31 11.6091 12.83 11.8991 12.54L17.4391 7L11.8991 1.46C11.6091 1.17 11.6091 0.689995 11.8991 0.399995C12.1891 0.109995 12.6691 0.109995 12.9591 0.399995L19.0291 6.47C19.3191 6.76 19.3191 7.24 19.0291 7.52999L12.9591 13.6C12.8091 13.75 12.6191 13.82 12.4291 13.82Z" fill="white"/>
          <path d="M18.33 7.75H1.5C1.09 7.75 0.75 7.41 0.75 7C0.75 6.59 1.09 6.25 1.5 6.25H18.33C18.74 6.25 19.08 6.59 19.08 7C19.08 7.41 18.74 7.75 18.33 7.75Z" fill="white"/>
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Step1",
  props: {
    systemOrderNo: String,
    orderListUrl: String,
  },
  data() {
    return {
      stepActive: false,
      clientOrderNo: '',
      systemOrder: '',
      loanNo: '',
      loanType: '',
      receiveDate: '',
      technologyFee: '',
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
  created() {
    this.systemOrder = this.systemOrderNo;
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
