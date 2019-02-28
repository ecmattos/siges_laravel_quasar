<template>
    <q-list highlight inset-separator>
        <q-list-header>ESTOQUE</q-list-header>
        <warehouses-supplies-component v-for="(warehouse, index) in  material.warehouse" :key="index"/>
        <q-item v-for="(warehouse, index) in  material.warehouse" :key="index">
            <q-item-main>
                <q-item-tile label-lines="1" label>{{ material.warehouse[index].code }} - {{ material.warehouse[index].description }}
                </q-item-tile>
            </q-item-main>
            <q-item-side right>          
                <q-chip small icon-right="remove_shopping_cart" color="tertiary" :disabled="cartItemQtyAdd <= 0" @click="cartItemDel(index, material.id, warehouse.id)">
                </q-chip>
                |
                <q-chip small icon-right="add_shopping_cart" :color="(cartItemQtyAdd > 0 ? 'secondary' : 'primary')" @click="cartItemAdd(index, material.id, warehouse.id)">
                    {{ cartItemQtyAdd }}
                </q-chip>
                |
                <q-chip small color="primary">{{ material.material_supply[index].qty - cartItemQtyAdd }}</q-chip>
            </q-item-side>
        </q-item>

        <q-item>
            <q-item-main>
                <q-item-tile label-lines="1" label>Total</q-item-tile>
            </q-item-main>
            <q-item-side right>          
                <q-chip small color="primary">10</q-chip>
            </q-item-side>
        </q-item>
    </q-list>
</template>

<script>
    import WarehousesSuppliesComponent from "../../components/materials/WarehousesSupplies";

    export default {
        data () {
            return {
                cartItemQtyAdd: 0
            }
        },
        components: {
            WarehousesSuppliesComponent    
        },

        props: {
            material: {
                type: Object
            }
        },
        methods: {
            cartItemAdd(index, material_id, warehouse_id) {
                this.$store.dispatch('cart/actCartItemAdd', [ material_id, warehouse_id ]);
                this.cartItemQtyAdded(index);
                //Vue.set(material.warehouse, index, {cartItemQtyAdd: this.cartItemQtyAdd});
            },
            cartItemDel(index, material_id, warehouse_id) {
                if (this.cartItemQtyAdd > 0) {
                    this.$store.dispatch('cart/actCartItemDel', [ material_id, warehouse_id ]);
                    this.catrItemQtyDeleted(index);
                }
            },
            cartItemQtyAdded(index) {
                this.cartItemQtyAdd ++;
            },
            catrItemQtyDeleted(index) {
                this.cartItemQtyAdd --;
            }
        }
    }
</script>

<style>
</style>

