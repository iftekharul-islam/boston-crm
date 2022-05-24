<template>
  <div class="row ">
    <div class="col-12">
      Files
      <div class="order-details-box bg-white">
        <div class="box-header">
          <p class="fw-bold text-light-black fs-20 mb-0">Files</p>
          <div class="group">
            <div v-b-modal.upload-files class="position-relative file-upload document-upload">
              <label for="">Upload <img src="/img/upload.png" alt="boston profile"></label>
            </div>
          </div>
        </div>
        <div class="box-body">
          document
          <div class="document">
            <div class="row">
              <div class="col-sm-6 col-md-4 col-lg-3">
                <p class="fw-bold text-light-black">Inspection</p>

                <div class="d-flex align-items-center mb-3">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                </div>
                <div class="d-flex align-items-center">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <p class="fw-bold text-light-black">Order</p>

                <div class="d-flex align-items-center mb-3">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                </div>
                <div class="d-flex align-items-center">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <p class="fw-bold text-light-black">Report <span class="text-danger">*</span></p>
                <div>
                  <p class="text-gray">Didnt add yet</p>
                  <div class="position-relative file-upload report-upload">
                    <input type="file">
                    <label for="">Upload <span class="icon-upload ms-3 fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></label>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                <p class="fw-bold text-light-black">Other</p>

                <div class="d-flex align-items-center mb-3">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                </div>
                <div class="d-flex align-items-center">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12">Improvements on 23.03.2022</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <b-modal id="upload-files" size="lg" title="Edit Basic Information">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Select file type <span class="require"></span></label>
              <b-form-select
                  v-model="fileData.fileType"
                  :options="fileTypes"
                  class="dashboard-input w-100">
                <template #first>
                  <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                </template>
              </b-form-select>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Select file <span class="require"></span></label>
              <b-form-file multiple v-model="fileData.files"></b-form-file>
            </div>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('upload-files')">Close</b-button>
        <b-button variant="primary" @click="saveOrderFiles">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
  export default {
    props:{
      orderId: String,
      fileTypes: Array
    },
    data(){
      return{
        fileData:{
          fileType: '',
          files: ''
        },
      }
    },
    methods:{
      saveOrderFiles(){
        console.log(this.fileTypes);
      }
    }
  }
</script>
