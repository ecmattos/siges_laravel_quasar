<template>
    <q-card>
        <q-card-media>
            <g-maps-markers-component :places="[customer]"></g-maps-markers-component>
        </q-card-media>

        <customers-address-component :customer="customer"></customers-address-component>

        <q-card-actions align="around">
            <q-btn flat round color="primary" :icon="(favorite ? 'favorite_border' : 'favorite')" @click="addFavorite"/>
            <q-btn flat round color="faded" icon="bookmark" />
            <q-btn flat round color="primary" icon="share" />
        </q-card-actions>
    </q-card>
</template>

<script>
    import GMapsMarkersComponent from '../../components/gmaps/Markers';
    import CustomersAddressComponent from '../../components/customers/Address';
    
    export default {
        data () {
            return {
                favorite: false
            }
        },
        props: {
            customer: {
                type: Object,
                required: true
            }
        },
        components: {
            GMapsMarkersComponent,
            CustomersAddressComponent
        },
        methods: {
            addFavorite () {
                console.log('favorite: ', this.favorite);
                this.favorite = !this.favorite;
            }
        }
    }
</script>

<style>
</style>

