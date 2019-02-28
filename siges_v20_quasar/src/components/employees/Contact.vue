<template>
    <q-card>
        <q-card-media>
            <g-maps-markers-component :places="{0: employee}"></g-maps-markers-component>
        </q-card-media>
        
        <q-list>
            <q-item>
                <q-item-side>
                    <q-item-tile color="primary" icon="place" />
                </q-item-side>
                
                <q-item-main>
                    <q-item-tile label>{{ employee.address }}, {{ employee.building }} {{ employee.building_comments }} - {{ employee.neighborhood }}</q-item-tile>
                    <q-item-tile sublabel>{{ employee.city }}/{{ employee.state }} - CEP: {{ employee.zip_code }}</q-item-tile>
                </q-item-main>
            </q-item>
            <q-item>
            <q-item-side>
                <q-item-tile color="red" icon="phone" />
            </q-item-side>
            <q-item-main>
                <q-item-tile label>{{ employee.mobile }}</q-item-tile>
                <q-item-tile sublabel>{{ employee.phone }}</q-item-tile>
            </q-item-main>
            </q-item>
            <q-item>
            <q-item-side>
                <q-item-tile color="amber" icon="mail" />
            </q-item-side>
            <q-item-main>
                <q-item-tile label>{{ employee.email }}</q-item-tile>
                <q-item-tile sublabel></q-item-tile>
            </q-item-main>
            </q-item>
        </q-list>

        <q-card-actions align="around">
            <q-btn flat round color="primary" :icon="(favorite ? 'favorite_border' : 'favorite')" @click="addFavorite"/>
            <q-btn flat round color="faded" icon="bookmark" />
            <q-btn flat round color="primary" icon="share" />
        </q-card-actions>
    </q-card>
</template>

<script>
    import GMapsMarkersComponent from '../../components/gmaps/Markers';
    
    export default {
        data () {
            return {
                favorite: false
            }
        },
        props: {
            employee: {
                type: Object
            }
        },
        components: {
            GMapsMarkersComponent
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

