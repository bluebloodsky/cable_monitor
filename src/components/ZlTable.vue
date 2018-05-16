<template>
  <table>
    <thead>
      <slot></slot>
    </thead>
  </table>
</template>
<script>
export default {
  props: {
    data: Array,
    fields: Array
  },
}

</script>
<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  color: #000;
}

td,
th,
table {
  border: 1px solid #C0C0C0;
  font-weight: normal;
}

thead {
  height: 30px;
  line-height: 30px;
  font-size: 16px;
  background-color: #B0C6DB;
}

</style>
