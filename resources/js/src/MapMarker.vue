<template>
    
</template>

<script>
export default {
    props: {
        lat: {type: Number, required: true},
        lng: {type: Number, required: true}
    },
    data: () => ({
        marker: null
    }),
    mounted() {
        this.$parent.getMap(map => {
            this.marker = new window.google.maps.Marker({
                position: {lat: this.lat, lng: this.lng},
                map: map,
                icon: this.$boston.host('img/marker.png'),
            });
        });
    }, 
    beforeDestroy() {
        this.marker.setMap(null);
        window.google.maps.event.clearInstanceListener(this.marker);
    },
    render() {
        return null;
    }
}
</script>