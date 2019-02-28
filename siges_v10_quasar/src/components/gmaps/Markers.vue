<template>
    <gmap-map 
        ref="gMap" 
        :center.sync="center" 
        :zoom.sync="zoom" 
        style="width: 100%; height: 300px"
        class="google-map">
        <gmap-info-window 
            :options="infoOptions" 
            :position="infoPosition" 
            :opened="infoOpened" 
            @closeclick="infoOpened=false">
                {{infoContent}}
        </gmap-info-window>
        <gmap-marker 
            v-for="(item, key) in places" 
            :key="key" 
            :position="getPosition(item)" 
            :clickable="true" 
            @click="toggleInfo(item, key)">
        </gmap-marker>
    </gmap-map>
</template>

<script>
    export default {
        data () {
            return {
                zoom: 2,
                center: {lat: 10.0, lng: 10.0},
                //places: [
                //    {
                //        name: 'Erich  Kunze',
                //        lat: '10.31',
                //        lng: '123.89'
                //    }
                //],
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
        props: {
            places: {
                type: Array,
                required: true
            }
        },
        mounted() {
            this.generateBounds();
            console.log("places: ", this.places);
        },
        methods: {
            getPosition: function(marker) {
                return {
                    lat: parseFloat(marker.lat),
                    lng: parseFloat(marker.lng)
                }
            },
            toggleInfo: function(marker, key) {
                this.infoPosition = this.getPosition(marker)
                this.infoContent = marker.name
                if (this.infoCurrentKey == key) {
                    this.infoOpened = !this.infoOpened
                } else {
                    this.infoOpened = true
                    this.infoCurrentKey = key
                }
            }, 
            generateBounds() {
                //console.log(Object.entries(this.places));
                this.$gmapApiPromiseLazy()
                .then(() => { 
                    let bounds = new google.maps.LatLngBounds();
                    this.places.forEach((place) => {
                        console.log("place: ", place);
                        bounds.extend(new google.maps.LatLng(place.lat, place.lng));

                        this.center = {
                            lat: place.lat,
                            lng: place.lng
                        };
                    });
                    console.log("bounds: ", bounds);

                    this.$refs.gMap.fitBounds(bounds);
                    this.$refs.gMap.panToBounds(bounds);
                });
            }
        }
    }
</script>