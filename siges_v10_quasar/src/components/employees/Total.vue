<template>
  <q-page>
    <transition
      enter-active-class="animated bounceInLeft"
      leave-active-class="animated bounceOutRight"
      appear
    >
      <q-alert
        :color="backgroundColor"
        :icon="iconName"
        :detail="title"
        :text-color="textColor"
        class="q-mb-sm"
      >
        <ICountUp
          :startVal="startVal"
          :endVal="total"
          :decimals="decimals"
          :duration="duration"
          :options="options"
          @ready="onReady"
        />
      </q-alert>
    </transition>
  </q-page>
</template>

<script>
  import ICountUp from 'vue-countup-v2';
  
  export default {
    data() {
      return {
        startVal: 0,
        //endVal: 0,
        decimals: 0,
        duration: 2.5,
        options: {
          useEasing: true,
          useGrouping: true,
          separator: '.',
          decimal: ',',
          prefix: '',
          suffix: ''
        }
      };
    },
    props: {
      title: {
        type: String, 
        required: true
      }, 
      total: {
        type: Number, 
        required: true
      }, 
      backgroundColor: {
        type: String, 
        required: true
      },
       textColor: {
        type: String, 
        required: true
      },
      iconName: {
        type: String, 
        required: true
      }
    },
    components: {
      ICountUp
    },
    computed: {
      //getEmployeesTotal() {
      //  return this.$store.getters['employees/getEmployeesTotal'];
      //}
    },
    created () {
      //this.endVal = this.total;
    },
    methods: {
      onReady(instance, CountUp) {
        let that = this;
        instance.update(that.endVal + 0);
      }
    }
  };
</script>

<style scoped>
  .iCountUp {
    font-size: 2em;
    margin: 0;
    color: white;
  }
</style>
