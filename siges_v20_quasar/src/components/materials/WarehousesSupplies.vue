<template>
   <q-item>
            <q-item-main>
                <q-item-tile label-lines="1" label>
                    TESTE
                </q-item-tile>
            </q-item-main>
            <q-item-side right>          
                <q-chip small icon-right="remove_shopping_cart" color="tertiary" :disabled="cartItemQtyAdd <= 0" @click="cartItemDel(index, material.id, warehouse.id)">
                </q-chip>
                |
                <q-chip small icon-right="add_shopping_cart" :color="(cartItemQtyAdd > 0 ? 'secondary' : 'primary')" @click="cartItemAdd(index, material.id, warehouse.id)">
                    TESTE
                </q-chip>
                |
                <q-chip small color="primary">TESTE</q-chip>
            </q-item-side>
        </q-item>
</template>

<script>
    export default {
       data () {
            return {
                
            }
        }
    }
</script>

<style>
</style>

