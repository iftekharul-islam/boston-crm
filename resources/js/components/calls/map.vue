<template>
   <transition name="fade">
     <div class="map-box">
        <div class="cancel" @click="closeMap()">
          <img src="/img/cancel.png" class="img-fluid">
        </div>
        <div class="map" ref="map" v-if="!mapNotFound"></div>
        <div class="text-center" v-else>
          Map Information Not Found
        </div>
      </div>
   </transition>
</template>


<script>
export default {
    name: "Mapview",
    props: ['latLng'],
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
        this.markerIcon = this.$boston.host('img/pin.png');
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
              icon: this.markerIcon,
              zoom: 10,
              mapTypeId: window.google.maps.MapTypeId.ROADMAP,
              gestureHandling: 'greedy'
          });
          this.buildMapWithMultipleLocations(this.map)
      },

      buildMapWithMultipleLocations(getMap) {
        let lcoationtions = this.latLng;
        const infowindow = new google.maps.InfoWindow();
        const geocoder = new google.maps.Geocoder();
        const map = getMap;
        let latAverage = 0;
        let lngAverage = 0;
        lcoationtions.forEach(function(locationItem, index) {
          geocoder.geocode({'address': locationItem.details.property.formatedAddress}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              const latitude = results[0].geometry.location.lat();
              const longitude = results[0].geometry.location.lng();
              
              latAverage = latitude;
              lngAverage = longitude;

              map.setCenter(new google.maps.LatLng(latAverage, lngAverage));
              this.setLocation(map, infowindow, longitude, latitude, locationItem);
            }
          }.bind(this));
        }.bind(this));
      },

      closeMap() {
        this.$emit('closeMap', true);
      },

      setLocation(map, infowindow, longitude, latitude, locationItem) {
        const marker = new google.maps.Marker({
          position: new google.maps.LatLng(latitude, longitude),
          map: map,
          icon: this.markerIcon,
        });

        google.maps.event.addListener(
          marker,
          'click',
          (function (marker) {
            return function () {
              infowindow.setContent(locationItem.details.property.full_addr);
              infowindow.open(map, marker)
            };
          })(marker)
        );
      }
    }
}

</script>

<style>

.map {
    height: 85vh;
    width: 85%;
    left: 50%;
    transform: translate(-50%, 5%);
    box-shadow: 0 8px 16px rgb(0 0 0 / 35%);
    border-radius: 0.25rem;
}

.map-box {
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 99999;
    top: 0;
    left: 0;
    backdrop-filter: blur(8px);
    background: rgba(0,0,0,0.5);
}

.cancel img {
    height: 45px;
    filter: invert(1);
    cursor: pointer;
}
.cancel {
    position: absolute;
    right: 11%;
    top: 5%;
    z-index: 999999;
}
</style>