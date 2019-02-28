<template>
  <!-- content -->
  <q-list highlight inset-separator>
    <q-list-header>Fornecedores</q-list-header>
    <q-item link multiline v-for="(provider, index) in providers" :key="index" :to="'/providers/'+provider.id">
      <q-item-side avatar="assets/img/user_default.png" />
      <q-item-main>
        <q-item-tile label-lines="1" label>{{ provider.name }}</q-item-tile>
        <q-item-tile sublabel-lines="2" sublabel>{{ provider.address }}</q-item-tile>
      </q-item-main>
      <q-item-side right>
        <q-item-tile stamp>{{ provider.mobile }}</q-item-tile>
      </q-item-side>
    </q-item>
  </q-list>
</template>

<script>
  export default {
    props: {
      providers: {
        type: Object
      }
    }
  }
</script>

<style>
</style>
