<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Property Information</p>
      <a href="#" v-b-modal.property-info class="d-inline-flex edit align-items-center fw-bold">Edit <span
          class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
    <div class="box-body">
      <div class="list__group">
        <p class="mb-0 left-side">Property address </p>
        <span>:</span>
        <p class="right-side mb-0 primary-text fw-bold fs-20">{{ info.search_address }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">State</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.state_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">City</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.city_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Street</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.street_name }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Latitude</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.latitude }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Longitude</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.longitude }}</p>
      </div>
      <div class="list__group">
        <p class="mb-0 left-side">Zip</p>
        <span>:</span>
        <p class="right-side mb-0">{{ info.zip }}</p>
      </div>
    </div>
    <b-modal id="property-info" size="lg" title="Edit Basic Information">
      <div class="modal-body">
        <b-alert v-if="message" show variant="success"><a href="#" class="alert-link">{{ message }}</a></b-alert>
        <div class="row">
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Search address <span class="require"></span></label>
              <input type="text" ref="searchMapLocation" v-model="info.search_address" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Street name <span class="require"></span></label>
              <input type="text" v-model="info.street_name" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">City name <span class="require"></span></label>
              <input type="text" v-model="info.city_name" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">State name <span class="require"></span></label>
              <input type="text" v-model="info.state_name" class="dashboard-input w-100">
            </div>
            <div class="divider"></div>
            <div class="group">
              <small>Edit with map location:</small>
              <a :href="`/orders/${order.id}/edit`" class="btn btn-sm btn-primary">Edit Here</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Unit # <span class="require"></span></label>
              <input type="text" v-model="info.unit_no" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">County <span class="require"></span></label>
              <input type="text" v-model="info.country" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Zip <span class="require"></span></label>
              <input type="text" v-model="info.zip" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Latitude <span class="require"></span></label>
              <input type="text" v-model="info.latitude" class="dashboard-input w-100">
            </div>
            <div class="group">
              <label for="" class="d-block mb-2 dashboard-label">Longitude <span class="require"></span></label>
              <input type="text" v-model="info.longitude" class="dashboard-input w-100">
            </div>
          </div>
        </div>
      </div>
      <div slot="modal-footer">
        <b-button variant="secondary" @click="$bvModal.hide('property-info')">Close</b-button>
        <b-button variant="primary" @click="updatePropertyInfo">Save</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  props:{
    orderId: String,
    order: []
  },
  data() {
    return {
      info:{
        search_address: '',
        street_name: '',
        city_name: '',
        state_name: '',
        zip:'',
        unit_no:'',
        country:'',
        longitude: '',
        latitude: ''
      },
      message: '',
      mapData: {
        map: null,
        center: {lat: null, lng: null},
      }
    }
  },
  created() {
    this.getPropertyInfo();
  },
  mounted() {

  },
  methods: {
    getPropertyInfo(){
        this.info.search_address = this.order.property_info.search_address
        this.info.street_name = this.order.property_info.street_name
        this.info.city_name = this.order.property_info.city_name
        this.info.state_name = this.order.property_info.state_name
        this.info.zip = this.order.property_info.zip
        this.info.country = this.order.property_info.country
        this.info.unit_no = this.order.property_info.unit_no
        this.info.latitude = this.order.property_info.latitude
        this.info.longitude = this.order.property_info.longitude
        this.mapData.center.lat = parseFloat(this.info.latitude);
        this.mapData.center.lng = parseFloat(this.info.longitude);
    },
    updatePropertyInfo(){
      let that = this
      axios.post('update-property-info/'+ this.orderId,this.info)
          .then(res => {
            that.message = res.data.message
            setTimeout(function(){
              that.$bvModal.hide('property-info')
              that.message = ''
            }, 2000);
          }).catch(err => {
            console.log(err)
      })
    },
  }
}
</script>
