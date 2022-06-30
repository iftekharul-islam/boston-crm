<template>
  <div class="order-details-box bg-white">
    <div class="box-header">
      <p class="fw-bold text-light-black fs-20 mb-0">Map</p>
    </div>
    <div class="box-body">
     <div class="map" ref="map" v-if="!mapNotFound">
        <!-- <MapMarker :lat="center.lat" :lng="center.lng"></MapMarker>
        <MapMarker v-for="item, li in latLon" :key="li+'map-lat-lon'" :lat="item.lat" :lng="item.lng"></MapMarker>
        <MapInfo v-for="item, lix in latLon" :key="lix+'map-details-data'" :lat="center.lat" :lng="center.lng" class="map-info-bg">
            <span style="text-align: center; color: #2473e8">Boston Order's Property Info:</span> <br><br>
            S.O.N: <strong style="color: #000">#{{ item.details.orderNo }}</strong> <br>
            {{ item.details.property.search_address }}
        </MapInfo> -->
      </div>
      <div class="text-center" v-else>
        Map Information Not Found
      </div>
    </div>
  </div>
</template>


<script>
import MapMarker from "../../src/MapMarker.vue";
import MapInfo from "../../src/MapInfo.vue";

export default {
    name: "Mapview",
    props: ['latLng'],
    components: {
      MapInfo, MapMarker
    },
    data: () => ({
        center: {
          lat: null,
          lng: null,
          details: null,
        },
        latLon: [],
        markerIcon: null,
        map: null,
        mapNotFound: false,
        message: null,
    }),
    created(){
        this.markerIcon = this.$boston.host('img/marker.png');
        this.latLng.map( (ele, index) => {
            if (index == 0) {
                this.center.lat = ele.lat;
                this.center.lng = ele.lng;
                this.center.details = ele.details;
            } else {
                this.latLon.push(ele);
            }
        });
    },
    mounted(){
      this.geolocate();
    },
    methods: {
      geolocate() {
        this.mapNotFound = window.google.maps === undefined ? true : false;
        this.map = new window.google.maps.Map(this.$refs['map'], {
            center:  this.center,
            zoom: 14,
            gestureHandling: 'greedy'
        });
        new window.google.maps.Marker({
            position: this.center,
            map: this.map,
            icon: this.markerIcon
        });
        
        // let mapItem = {
        //     position: {
        //         lat: ele.lat,
        //         lng: ele.lng,
        //     },
        //     map: this.map,
        //     icon: this.markerIcon
        // };
        // new window.google.maps.Marker(mapItem);
    },

    getMap(callback) {
        let vm = this;
        function checkForMap() {
          if (vm.map) callback(vm.map)
          else setTimeout(checkForMap, 200)
        }
        checkForMap();
      }
    }
}

</script>

<style>

.map {
  height: 400px;
}
.map-info-bg{
  color: #00c851;
  font-weight: bold;
}

</style>