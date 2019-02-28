<template>
  <q-page padding>
    <!-- content -->
    <q-search 
      autofocus
      v-model="search_terms"
      float-label="Informe nome ou endereço ou celular"
      placeholder="."
      clearable
      hide-underline>
    </q-search>
    
    <hr>

    <q-list striped-odd dense no-border inset-separator>
      <q-item link multiline v-for="(customer, index) in customersFilter" :key="index" :to="'/customers/'+customer.id">
        <q-item-side avatar="assets/img/user_default.png" />
        <q-item-main>
          <q-item-tile label-lines="1" label>{{ customer.name }}</q-item-tile>
          <q-item-tile sublabel-lines="1" sublabel>{{ customer.address }}, {{ customer.building }} {{ customer.building_comments }} - {{ customer.neighborhood }}</q-item-tile>
          <q-item-tile sublabel-lines="1" sublabel>{{ customer.city }}/{{ customer.state }} - CEP: {{ customer.zip_code }}</q-item-tile>
        </q-item-main>
      </q-item>
    </q-list>

    <q-page-sticky position="top-right" :offset="[18, 18]">
      <q-btn 
        round 
        color="primary" 
        icon="group">
        <q-chip floating color="red">{{ customersFilterCounter }}</q-chip>
      </q-btn>
    </q-page-sticky>

    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn
        round
        color="secondary"
        @click="goToPageCustomersNew"
        icon="add"/>
    </q-page-sticky>
  </q-page>
  
</template>

<script>
  export default {
    data() {
      return {
        search_terms: '' 
      }
    },
    mounted() {
      this.$store.dispatch('auth/actPageSet', ['CLIENTES', 'Pesquisa']);
      this.$store.dispatch('customers/actCustomersAll');
    },
    methods: {
      customerShow () {
        //alert('OK');
        this.$store.dispatch('auth/actPageSet', ['CLIENTE', 'Consulta']);
      },
      goToPageCustomersNew () {
        this.$router.push('/customers/new');
      }
    },
    computed: {
      customersFilter() {
        let search_terms = this.search_terms.trim().toLowerCase();
        if (search_terms === '') return this.$store.getters['customers/getCustomers'];
        return this.$store.getters['customers/getCustomers'].filter((customers) => {
          return customers.name.toLowerCase().indexOf(search_terms) > -1 || customers.address.toLowerCase().indexOf(search_terms) > -1 || customers.mobile.toLowerCase().indexOf(search_terms) > -1;
        });
      },
      customersFilterCounter() {
        return this.customersFilter.length;
      }
    }
  }
</script>

<style>
</style>
