<template>
  <q-page padding>
    <q-card>
      <q-item>
        <q-item-main>
          <q-item-tile label>{{ material.code }}</q-item-tile>
          <q-item-tile sublabel>{{ material.description }}</q-item-tile>
        </q-item-main>
        <q-item-side right>
          {{ material.material_unit.code }}
        </q-item-side>
      </q-item>
    </q-card>

    <br>
    
    <transition
      appear
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
    >
      <div v-if="tabSelected === 'tabHome'">
        <material-home-component :material="material"></material-home-component>
        <br>
        <material-warehouses-component :material="material"></material-warehouses-component>
      </div>

      <div v-if="tabSelected === 'tabProviders'">
        <material-providers-component :providers="providers"></material-providers-component>

        <q-page-sticky position="bottom-right" :offset="[18, 18]">
          <q-fab
            color="purple"
            icon="keyboard_arrow_up"
            direction="up"
          >
            <q-fab-action
              color="primary"
              @click="goToPageMaterials"
              icon="search"
            />

            <q-fab-action
              color="secondary"
              @click="goToPageMaterialsNew"
              icon="create"
            />
          </q-fab>
        </q-page-sticky>
      </div>
    </transition>

    <q-layout-footer>
      <q-tabs class="shadow-2" align="justify">
        <q-tab default slot="title" icon="mail" @click="tabHomeSelected" />
        <q-tab count="5" slot="title" icon="movie"  @click="tabProvidersSelected" />
        <q-tab :count="cartItemsTotal" slot="title" icon="shopping_cart" @click="tabCartSelected" />
      </q-tabs>
    </q-layout-footer>
  </q-page>
  
</template>

<script>
  import MaterialHomeComponent from '../../components/materials/Home';
  import MaterialProvidersComponent from '../../components/materials/Providers';
  import MaterialWarehousesComponent from '../../components/materials/Warehouses';

  export default {
    data() {
      return {
        tabSelected: 'tabHome',
        material_id: this.$route.params.id,
        material: this.$store.getters['materials/getMaterialsSearchById'](this.$route.params.id)
      }
    },
    components: {
      MaterialHomeComponent,
      MaterialProvidersComponent,
      MaterialWarehousesComponent
    },
    mounted() {
      console.log('material_id: ', this.$route.params.id);
      this.$store.dispatch('auth/actPageSet', ['MATERIAL', 'Consulta']);
    },
    methods: {
      goToPageMaterials () {
        this.$router.push('/materials');
      },
      goToPageMaterialsNew () {
        this.$router.push('/materials/new');
      },
      tabHomeSelected(){
        this.$store.dispatch('auth/actPageSet', ['MATERIAL', 'Consulta']);
        this.tabSelected = 'tabHome';
      },
      tabSuppliesSelected(){
        this.$store.dispatch('auth/actPageSet', ['MATERIAL', 'Estoque - Consulta']);
        this.tabSelected = 'tabSupplies';
      },
      tabProvidersSelected(){
        this.$store.dispatch('auth/actPageSet', ['MATERIAL', 'Fornecedores - Pesquisa']);
        this.tabSelected = 'tabProviders';
      },

      tabCartSelected(){
        
      }
    },
    computed: {
      cartItemsTotal() {
        return this.$store.getters['cart/getCartItemsTotal'];
      }
    }
  }
</script>

<style>
</style>
