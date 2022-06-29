<template>
  <transition name="fade" appear>
    <div class="map-box">
        <div class="close" @click="closeMap">
            <img src="/img/close-map.png" class="img-fluid">
        </div>
        <div class="box-body">
            <div class="map" id="multiMap" ref="map" v-if="!mapNotFound"></div>
            <div class="text-center" v-else>
                Map Information Not Found
            </div>
        </div>
    </div>
  </transition>
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
        this.markerIcon = this.$boston.host('img/marker-2.png');
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
            this.buildMapWithMultipleBuyerLocations();
        },

        buildMapWithMultipleBuyerLocations() {
            const infowindow = new window.google.maps.InfoWindow();
            const geocoder = new window.google.maps.Geocoder();
            const map = new window.google.maps.Map(document.getElementById('multiMap'), {
                zoom: 8,
                center: this.center,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                gestureHandling: 'greedy'
            });
            let latAverage = 0;
            let lngAverage = 0;
            this.latLng.forEach(function(buyerLocation, index) {
                let property = buyerLocation.details.property.formatedAddress;
                geocoder.geocode({'address': property}, function(results, status) {
                    if (status == window.google.maps.GeocoderStatus.OK) {
                        const latitude = results[0].geometry.location.lat();
                        const longitude = results[0].geometry.location.lng();                    
                        latAverage = latitude;
                        lngAverage = longitude;
                        map.setCenter(new window.google.maps.LatLng(latAverage, lngAverage));
                        this.setLocation(map, infowindow, longitude, latitude, property);
                    }
                }.bind(this));
            }.bind(this));
        },

        setLocation(map, infowindow, longitude, latitude, propertyName) {
            const marker = new window.google.maps.Marker({
                position: new window.google.maps.LatLng(latitude, longitude),
                map: map,
                icon: this.markerIcon
            });
            window.google.maps.event.addListener(
                marker,
                'click',
                (function (marker) {
                return function () {
                    infowindow.setContent(propertyName)
                    infowindow.open(map, marker)
                };
                })(marker)
            );
        },

        getMap(callback) {
            let vm = this;
            function checkForMap() {
            if (vm.map) callback(vm.map)
            else setTimeout(checkForMap, 200)
            }
            checkForMap();
        },
        closeMap() {
            this.$emit('closeMap', true);
        }
    }
}

</script>

<style>

.map-box {
    position: fixed;
    left: 50%;
    width: 90%;
    height: 90%;
    transform: translate(-50%, 5%);
    backdrop-filter: blur(10px);
    top: 0%;
    z-index: 99999999999;
    overflow: hidden;
    border-radius: 0.25rem;
    box-shadow: 0 50px 80px rgba(0,0,0,0.8);
}

.map {
  height: 90vh;
}
.map-info-bg{
  color: #00c851;
  font-weight: bold;
}

.map-box .box-header {
    background: #fff;
    padding: 5px 15px;
}

.map-box .close img {
    height: 40px;
    position: absolute;
    z-index: 9;
    right: 70px;
    top: 10px;
    cursor: pointer;
    border-radius: 50%;
    filter: invert(1);
}

</style>