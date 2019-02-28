<template>
  <q-page padding>
    <!-- content -->
  </q-page>
</template>

<script>
export default {
  mounted () {
    this.$store.dispatch('auth/actPageSet', ['MATERIAL', 'Inclusão']);
  }
}
</script>

<style>
</style>
