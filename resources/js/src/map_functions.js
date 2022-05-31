function geolocate() {
    this.map = new window.google.maps.Map(this.$refs['map'], {
        center: this.center,
        zoom: 7,
        gestureHandling: 'greedy'
    });
    new window.google.maps.Marker({
        position: this.center,
        map: this.map,
        icon: this.markerIcon
    });

    const input = this.$refs.mapSearch;
    const searchBox = new window.google.maps.places.SearchBox(input);
    this.map.controls[window.google.maps.ControlPosition.TOP_LEFT].push(input);
    this.map.addListener("bounds_changed", () => {
        searchBox.setBounds(this.map.getBounds());
    });

    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }


        // For each place, get the icon, name and location.
        const bounds = new window.google.maps.LatLngBounds();
        let markers = [];

        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }

            const icon = {
                url: place.icon,
                size: new window.google.maps.Size(71, 71),
                origin: new window.google.maps.Point(0, 0),
                anchor: new window.google.maps.Point(17, 34),
                scaledSize: new window.google.maps.Size(25, 25),
            };

            // Create a marker for each place.
            markers.push(
                new window.google.maps.Marker({
                    map: this.map,
                    icon: this.markerIcon,
                    title: place.name,
                    position: place.geometry.location,
                })
            );

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            let addressData = {
                postal_code: null,
                country: null,
                name: null,
                street: null,
                city: null,
                location: null,
                lat: null,
                lon: null,
                place_id: null,
            };
            addressData.place_id = place.place_id;
            // Location details
            for (var i = 0; i < place.address_components.length; i++) {
                if (place.address_components[i].types[0] == 'postal_code') {
                    addressData.postal_code = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'route') {
                    addressData.street = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'administrative_area_level_2') {
                    addressData.city = place.address_components[i].long_name;
                }
                if (place.address_components[i].types[0] == 'country') {
                    addressData.country = place.address_components[i].long_name;
                }
            }
            addressData.name = place.name;
            addressData.location = place.formatted_address;
            addressData.lat = place.geometry.location.lat();
            addressData.lon = place.geometry.location.lng();

            console.log(addressData);
            console.log(`${addressData.lat}, ${addressData.lon}`);

        });
        this.map.fitBounds(bounds);
    });
}

function getMap(callback) {
    let vm = this;

    function checkForMap() {
        if (vm.map) callback(vm.map)
        else setTimeout(checkForMap, 200)
    }
    checkForMap();
}