<template>
    <q-list>
        <q-item>
            <q-item-side>
                <q-item-tile color="primary" icon="place" />
            </q-item-side>
                
            <q-item-main>
                <q-item-tile label>{{ customer.address }}, {{ customer.building }} {{ customer.building_comments }} - {{ customer.neighborhood }}</q-item-tile>
                <q-item-tile sublabel>{{ customer.city }}/{{ customer.state }} - CEP: {{ customer.zip_code }}</q-item-tile>
            </q-item-main>
        </q-item>
        <q-item>
            <q-item-side>
                <q-item-tile color="red" icon="phone" />
            </q-item-side>
            <q-item-main>
                <q-item-tile label>{{ customer.mobile }}</q-item-tile>
                <q-item-tile sublabel>{{ customer.phone }}</q-item-tile>
            </q-item-main>
        </q-item>
        <q-item>
            <q-item-side>
                <q-item-tile color="amber" icon="mail" />
            </q-item-side>
            <q-item-main>
                <q-item-tile label>{{ customer.email }}</q-item-tile>
                <q-item-tile sublabel></q-item-tile>
            </q-item-main>
        </q-item>
    </q-list>
</template>

<script>
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

