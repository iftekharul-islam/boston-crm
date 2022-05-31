<template>
  <div class="row ">
    <div class="col-12">
      <!-- Files -->
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
          <!-- document -->
          <div class="document">
            <div class="row">
              <div class="col-sm-6 col-md-4 col-lg-3" v-for="(files,type) in orderFiles" :key="type">
                <p class="fw-bold text-light-black">{{ type }}</p>
                <div class="d-flex align-items-center mb-3" v-for="file in files">
                  <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                  <span class="text-light-black d-inline-block mgl-12"><a :href="file.original_url" download>{{ file.name }}</a></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <b-modal id="upload-files" size="lg" title="Uploads Order Files">
      <div class="modal-body">
        <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
        <div class="row">
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Select file type <span class="require"></span></label>
              <b-form-select
                  v-model="fileData.file_type"
                  :options="orderFileTypes"
                  class="dashboard-input w-100">
                <template #first>
                  <b-form-select-option value="" disabled>-- Please select an option --</b-form-select-option>
                </template>
              </b-form-select>
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Select file <span class="require"></span></label>
              <input type="file" multiple v-on:change="addFiles">
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
      orderFileTypes: [],
      orderFiles: []
    },
    data(){
      return{
        fileData:{
          file_type: '',
          files: [],
        },
        message: ''
      }
    },
    created(){
      console.log(this.orderFiles)
    },
    methods:{
      addFiles(event){
        this.fileData.files = event.target.files
      },
      saveOrderFiles(){
        let that = this
        let formData = new FormData();
        for( let i = 0; i < this.fileData.files.length; i++ ){
          let file = this.fileData.files[i];
          formData.append('files[' + i + ']', file);
        }
        formData.append('file_type',this.fileData.file_type)
        axios.post('upload-order-files/'+ this.orderId,formData,{ headers: {
          'Content-Type': 'multipart/form-data'
        }})
            .then(res => {
              this.message = res.data.message
              setTimeout(function(){
                that.$bvModal.hide('upload-files')
                that.message = ''
              }, 2000);
            }).catch(err => {
              console.log(err)
        })
      }
    }
  }
</script>
