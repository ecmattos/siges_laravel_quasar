<template>
    <gmap-map v-if="mapLoaded"
        ref="map" 
        id="map"
        :center="center" 
        :zoom="14" 
        style="width: 100%; height: 330px"
        class="google-map"
    >
        <gmap-info-window 
            :options="infoOptions" 
            :position="infoPosition" 
            :opened="infoOpened" 
            @closeclick="infoOpened=false"
        >
            <b>{{ infoContent }}</b>
        </gmap-info-window>

        <gmap-marker 
            :key="index"
            v-for="(place, index) in places" 
            :position="getPosition(place)" 
            :clickable="true" 
            :draggable="false"
            @click="toggleInfo(place, key)" />
    </gmap-map>
 </template>

<script>
    export default {
        data() {
            return {
                center: {},
                places: {
                    0: {
                        name: 'Erich  Kunze',
                        lat: -30.10,
                        lng: -51.25
                    },
                    1: {
                        name: 'Erico  Kunze',
                        lat: -30.33,
                        lng: -51.44
                    }
                },
                map: null,
                mapLoaded: false,
                infoPosition: null,
                infoContent: null,
                infoOpened: false,
                infoCurrentKey: null,
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    }
                }
            }
        },
        //props: {
        //    places: {
        //        type: Object
        //    }
        //},
        mounted() {
            this.mapLoaded = true;
            //this.geolocate();
            this.setCenterZoom();
            //console.log('place: ', this.place);
        },
        methods: {
            getPosition(marker) {
                console.log("marker1: ", marker);
                return {
                    lat: parseFloat(marker.lat),
                    lng: parseFloat(marker.lng)
                }
            },
            toggleInfo(marker, key) {
                this.infoPosition = this.getPosition(marker);
                this.infoContent = marker.name;
                if (this.infoCurrentKey == key) {
                    this.infoOpened = !this.infoOpened;
                } else {
                    this.infoOpened = true;
                    this.infoCurrentKey = key;
                }
            },
            setCenterZoom() {
                let places_total = Object.keys(this.places).length;

                alert(places_total);

                this.$gmapApiPromiseLazy()
                .then(() => { 
                    let bounds = new google.maps.LatLngBounds();
                    for (let i = 0; i < places_total; i++) {
                        let loc = new google.maps.LatLng(Object.values(this.places[i])[1], Object.values(this.places[i])[2]);

                        //alert(Object.keys(this.places[i]));
                        console.log("place_lat: ", Object.values(this.places[i])[1]);
                        console.log("place_lng: ", Object.values(this.places[i])[2]);
                        //bounds.extend(this.loc);
                    }
                    //console.log("bounds: ", bounds);
                    //this.center =  this.map.panToBounds(bounds);
                    //console.log("center: ", this.center);
                    //this.map.setCenter(this.center);
                });
            },
            geolocate() {
                this.$gmapApiPromiseLazy()
                .then(() => { 
                    let bounds = new google.maps.LatLngBounds();
                    console.log("places: ", 1);
                    //for (let i = 0; i < this.places.length; i++) {
                    //    //bounds.extend(this.places[i].getPosition());
                    //    console.log("place1: ", i);
                    //}
                    //this.map.setCenter(this.center);
                });

                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    //this.center = this.getPosition(marker);

                //    console.log("center: ", this.center);
                });


               

                //map.setCenter(bounds.getCenter());
                //map.fitBounds(bounds);
                
                //auto-zoom
                //map.fitBounds(bounds);
                //auto-center
                //map.panToBounds(bounds);
                //map.setCenter(bounds.getCenter());

                //console.log("map: ", bounds);
            }
        }
    };
</script>

bounds
bounds
bounds
bounds