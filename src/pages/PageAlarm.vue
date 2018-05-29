<template>
  <article>
    <header>
      
    </header>
    <section>

    </section>
  </article>
</template>

<script>
  import DashboardBox from "../components/DashboardBox";
  import {
    binaraySearch
  } from '@/shared/util'
  export default {
    components: {
      DashboardBox
    },
    data() {
      return {
        key: 12,
        arr: ''
      }
    },
    computed: {
      result() {
        return binaraySearch(this.key, this.arr.split(','))
      }
    }
  };
</script>

<style scoped>
  
</style>