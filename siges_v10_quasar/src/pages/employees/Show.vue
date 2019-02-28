<template>
  <q-page padding>
    <q-card>
      <q-item>
        <q-item-side avatar="assets/img/user_default.png" />
        <q-item-main>
          <q-item-tile label>{{ employee.name }}</q-item-tile>
          <q-item-tile sublabel>CPF: {{ employee.cpfcnpj }}</q-item-tile>
        </q-item-main>
        <q-item-side right color="primary" icon="create" />
      </q-item>
    </q-card>

    <br>
    
    <transition
      appear
      enter-active-class="animated fadeIn"
      leave-active-class="animated fadeOut"
    >
      <div v-if="tabSelected === 'tabContact'">
        <employee-contact-component :employee="employee"></employee-contact-component>

        <q-page-sticky position="bottom-right" :offset="[18, 18]">
          <q-fab
            color="purple"
            icon="keyboard_arrow_up"
            direction="up"
          >
            <q-fab-action
              color="primary"
              @click="goToPageEmployees"
              icon="search"
            />

            <q-fab-action
              color="secondary"
              @click="goToPageEmployeesNew"
              icon="create"
            />
          </q-fab>
        </q-page-sticky>
      </div>
    </transition>

    <q-layout-footer>
      <q-tabs class="shadow-2" align="justify">
        <q-tab default slot="title" icon="mail" label="Contato" @click="tabContactSelected" />
        <q-tab count="5" slot="title" icon="movie" label="Serviços" @click="tabOrdersSelected" />
      </q-tabs>
    </q-layout-footer>
  </q-page>
  
</template>

<script>
  import EmployeeContactComponent from '../../components/employees/Contact';  

  export default {
    data() {
      return {
        tabSelected: 'tabContact',
        employee_id: this.$route.params.id,
        employee: this.$store.getters['employees/getEmployeeById'](this.$route.params.id)
      }
    },
    components: {
      EmployeeContactComponent
    },
    mounted() {
      console.log('employee_id: ', this.$route.params.id);
      this.$store.dispatch('auth/actPageSet', ['CLIENTE', 'Consulta']);
    },
    methods: {
      goToPageEmployees () {
        this.$router.push('/employees');
      },
      goToPageEmployeesNew () {
        this.$router.push('/employees/new');
      },
      tabContactSelected(){
        this.$store.dispatch('auth/actPageSet', ['CLIENTE', 'Consulta']);
        this.tabSelected = 'tabContact'
      },
      tabOrdersSelected(){
        this.$store.dispatch('auth/actPageSet', ['CLIENTE', 'Ordens - Pesquisa']);
        this.tabSelected = 'tabOrders'
      }
    }
  }
</script>

<style>
</style>
