<template>
  <th>{{label}}</th>
</template>
<script>
export default {
  props: {
    label: String,
    prop: String,
    sortable: {
      type: [String, Boolean],
      default: false
    },
    formatter: Function
  },
  data() {
    return {

    }
  },

}

</script>
