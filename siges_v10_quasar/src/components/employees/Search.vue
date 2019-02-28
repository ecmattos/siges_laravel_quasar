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

    <q-list highlight inset-separator>
      <q-item link multiline v-for="(employee, index) in employeesFilter" :key="index" :to="'/employees/'+employee.id">
        <q-item-side avatar="assets/img/user_default.png" />
        <q-item-main>
          <q-item-tile label-lines="1" label>{{ employee.name }}</q-item-tile>
          <q-item-tile sublabel-lines="1" sublabel>{{ employee.address }}, {{ employee.building }} {{ employee.building_comments }} - {{ employee.neighborhood }}</q-item-tile>
          <q-item-tile sublabel-lines="1" sublabel>{{ employee.city }}/{{ employee.state }} - CEP: {{ employee.zip_code }}</q-item-tile>
        </q-item-main>
        <q-item-side right>
          <q-item-tile stamp>{{ employee.mobile }}</q-item-tile>
        </q-item-side>
      </q-item>
    </q-list>

    <q-page-sticky position="top-right" :offset="[18, 18]">
      <q-btn 
        round 
        color="primary" 
        icon="group">
        <q-chip floating color="red">{{ employeesFilterCounter }}</q-chip>
      </q-btn>
    </q-page-sticky>

    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn
        round
        color="secondary"
        @click="goToPageEmployeesNew"
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
      this.$store.dispatch('auth/actPageSet', ['FUNCIONÁRIOS', 'Pesquisa']);
      this.$store.dispatch('employees/actEmployeesAll');
    },
    methods: {
      employeeShow () {
        //alert('OK');
        this.$store.dispatch('auth/actPageSet', ['FUNCIONÁRIO', 'Consulta']);
      },
      goToPageEmployeesNew () {
        this.$router.push('/employees/new');
      }
    },
    computed: {
      employeesFilter() {
        let search_terms = this.search_terms.trim().toLowerCase();
        if (search_terms === '') return this.$store.getters['employees/getEmployees'];
        return this.$store.getters['employees/getEmployees'].filter((employees) => {
          return employees.name.toLowerCase().indexOf(search_terms) > -1 || employees.address.toLowerCase().indexOf(search_terms) > -1 || employees.mobile.toLowerCase().indexOf(search_terms) > -1;
        });
      },
      employeesFilterCounter() {
        return this.employeesFilter.length;
      }
    }
  }
</script>

<style>
</style>
