<template>
    <q-card>
        <q-card-media>
            <img src="~assets/img/customer_map.png">
        </q-card-media>
        <q-list>
            <q-item>
                <q-item-side>
                    <q-item-tile color="primary" icon="place" />
                </q-item-side>
                
                <q-item-main>
                    <q-item-tile label>{{ material.specification }}</q-item-tile>
                </q-item-main>
            </q-item>
        </q-list>

        <q-card-actions align="around">
            <q-btn flat round color="primary" :icon="(favorite ? 'favorite' : 'favorite_border')" @click="addFavorite"/>
            <q-btn flat round color="faded" icon="bookmark" />
            <q-btn flat round color="primary" icon="share" />
        </q-card-actions>
    </q-card>    
</template>

<script>
    export default {
        data () {
            return {
                favorite: false
            }
        },
        props: {
            material: {
                type: Object
            }
        },
        methods: {
            addFavorite () {
                console.log('favorite: ', this.favorite);
                this.favorite = !this.favorite;

                if (this.favorite === true) {
                    this.$q.notify({
                        message: 'Adicionado aos Favoritos !',
                        timeout: 1000,
                        color: 'green',
                        icon: 'favorite',
                        position: 'top-right'
                    });
                }
                else {
                    this.$q.notify({
                        message: 'Removido dos Favoritos!',
                        timeout: 1000,
                        color: 'red', 
                        icon: 'favorite_border',
                        position: 'top-right'
                    });
                }
            }
        }
    }
</script>

<style>
</style>

