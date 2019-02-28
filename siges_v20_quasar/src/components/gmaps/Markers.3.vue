<template>
    <gmap-map
        ref="gMap" 
        :center.sync="center" 
        :zoom.sync="zoom"
        style="width: 100%; height: 330px"
        class="google-map"
    >
        <gmap-marker
            :key="index"
            v-for="(p, index) in places"
            :position="{lat: p.lat, lng: p.lng}"
            :clickable="true"
            :draggable="false"
            @click="center={lat: p.lat, lng: p.lng}">
        </gmap-marker>
    </gmap-map>
</template>

<script>
    export default {
        data () {
            return {
                zoom: 10,
                center: {lat: 10.0, lng: 10.0},
                places: [
                    {
                        name: 'Erich  Kunze',
                        lat: -30.10,
                        lng: -51.25
                    },
                    {
                        name: 'Erico  Kunze',
                        lat: -30.33,
                        lng: -51.44
                    },
                    {
                        name: 'Erica  Kunze',
                        lat: -30.89,
                        lng: -51.04
                    }
                ]
            }
        },
        //props: {
        //    places: {
        //        type: Object,
        //        required: true
        //    }
        //},
        mounted() {
            this.generateBounds();
            console.log("places: ", this.places);
        },
        methods: {
            generateBounds() {
                this.$gmapApiPromiseLazy()
                .then(() => { 
                    let bounds = new google.maps.LatLngBounds();
                    this.places.forEach((place) => {
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