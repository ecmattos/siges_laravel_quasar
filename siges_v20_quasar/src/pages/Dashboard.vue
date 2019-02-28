<template>
  <q-page padding>
    <div class="overflow-hidden">
      <!-- the row with a type of gutter -->
      <div class="row gutter-sm">
        <div class="col-xs-12 col-sm-6 col-md-4">
          <customers-total-component 
            title="Clientes" 
            iconName="people"
            :total="getCustomersTotal" 
            backgroundColor="secondary"
            textColor="white">
          </customers-total-component>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <materials-total-component 
            title="Materiais" 
            iconName="all_inbox"
            :total="getMaterialsTotal" 
            backgroundColor="primary"
            textColor="white">
          </materials-total-component>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <users-total-component 
            title="Usuarios" 
            iconName="all_inbox"
            :total="getUsersTotal" 
            backgroundColor="green"
            textColor="white">
          </users-total-component>
        </div>
      </div>
    </div> 

    <div class="overflow-hidden">
      <!-- the row with a type of gutter -->
      <div class="row gutter-sm">
        <div class="col-xs-12 col-sm-6 col-md-4">
          <employees-total-component 
            title="Funcionários" 
            iconName="people"
            :total="getEmployeesTotal" 
            backgroundColor="info"
            textColor="white">
          </employees-total-component>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
        </div>
      </div>
    </div> 
  </q-page>
</template>

<script>
import CustomersTotalComponent from '../components/customers/Total';
import MaterialsTotalComponent from '../components/materials/Total';
import UsersTotalComponent from '../components/users/Total';
import EmployeesTotalComponent from '../components/employees/Total';

export default {
  // name: 'PageName',
  components: {
    CustomersTotalComponent,
    MaterialsTotalComponent,
    UsersTotalComponent,
    EmployeesTotalComponent
  },
  computed: {
    getCustomersTotal() {
      return this.$store.getters['customers/getCustomersTotal'];
    },
    getMaterialsTotal() {
      return this.$store.getters['materials/getMaterialsTotal'];
    },
    getUsersTotal() {
      return this.$store.getters['users/getUsersTotal'];
    },
    getEmployeesTotal() {
      return this.$store.getters['employees/getEmployeesTotal'];
    }
  },
  mounted () {
    this.$store.dispatch('customers/actCustomersAll');
    this.$store.dispatch('materials/actMaterialsAll');
    this.$store.dispatch('users/actUsersAll');
    this.$store.dispatch('employees/actEmployeesAll');
  }
}
</script>

<style>
</style>
