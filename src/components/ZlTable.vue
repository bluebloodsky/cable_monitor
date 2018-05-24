<template>
  <table>
    <thead>
      <tr>
        <th>序号</th>
        <th v-for="field in fields">{{field.caption}}</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row,row_id) in data">
        <td><span>{{row_id + 1}}</span></td>
        <td v-for="field in fields">
          <i class="iconfont" :class="row[field.name]" v-if="field.name=='icon'"></i>
          <span v-else>{{row[field.name]}}</span>
        </td>
        <td>
          <button @click="editRow(row,row_id)" type="text"><i class="iconfont icon-brush"></i>
          </button>
          <button @click="delRow(row,row_id)" type="text"><i class="iconfont icon-trash"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  props: {
    data: Array,
    fields: Array
  },
  methods: {
    editRow(row, row_id) {
      this.$emit('edit-row', row, row_id)
    },
    delRow(row, row_id) {
      this.$emit('del-row', row, row_id)
    }
  }
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
  background-color: #B0C6DB;
  line-height: 35px;
  font-size: 16px;
}

tbody {
  font-size: 14px;
  text-align: center;
  line-height: 35px;
}

tr:nth-child(even) {
  background-color: #EAF1F7;
}

.iconfont {
  font-size: 18px;
}

.icon-brush {
  color: #28A646;
}

.icon-trash {
  color: #C55C60;
}

</style>
