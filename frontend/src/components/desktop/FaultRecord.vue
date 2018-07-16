<template>
  <section>
    <div>
      <table>
        <thead>
          <tr>
            <th v-for="field in fields">{{field.caption}}</th>
          </tr>
        </thead>
        <tbody>
            <tr v-for="(row,row_id) in data" :class="row.level==1?'warn':'bad'" @click="rowClick">
        <td v-for="field in fields">
          <span>{{row[field.name]}}</span>
        </td>
          </tr>
        </tbody>
      </table>
    </div>
    <footer>
         <button type="text">
          <i class="iconfont icon-angle-double-left"></i>
        </button>
        <button type="text">
          <i class="iconfont icon-return"></i>
        </button>
        <input value="1">
        <button type="text">
          <i class="iconfont icon-enter"></i>
        </button>
        <button type="text">
          <i class="iconfont icon-angle-double-right"></i>
        </button>
        <span> 共1页 0条</span>
    </footer>
  </section>
</template>
<script>
import {
  ALARM_RECORDS
    } from "@/json/json_event";
export default {
  data() {
    return {
      fields: [
        { name: "name", caption: "告警线路" },
        { name: "time", caption: "告警时间" },
        { name: "type", caption: "告警类型" },
        { name: "level_desc", caption: "告警级别" },
      ],
      data:ALARM_RECORDS
    };
  },
  methods:{
    rowClick(e){
      this.$router.push('alarm')
    }
  }
};
</script>
<style scoped>
section {
  position: relative;
  width: 100%;
  height: 100%;
  font-size: 16px;
}
header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  padding-left: 15px;
  background-color: #1e364e;
  border-bottom: 1px solid #406985;
  margin-bottom: 3px;
}

header:before {
  content: "";
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 18px solid #406985;
  border-right: 18px solid transparent;
}

header:after {
  content: "";
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 16px solid #132d48;
  border-right: 16px solid transparent;
}
section > div {
  max-height: calc(100% - 40px);
  overflow-y: auto;
}

footer {
  position: absolute;
  bottom: 0;
  top: auto;
  left: 0;
  right: 0;
  height: 40px;
  line-height: 40px;
  padding-left: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

td,
th,
table {
  border: 1px solid #2b4f69;
  font-weight: normal;
}

thead {
  background-color: #06192a;
  line-height: 40px;
}

tbody {
  line-height: 40px;
  text-align: center;
}

a {
  color: #dff789;
  text-decoration: underline;
}


tbody tr:hover{
  background-color: #104666;
  cursor: pointer;
}
footer div {
  margin-right: 50px;
  float: left;
}

input {
  width: 20px;
  text-align: center;
}

.iconfont {
  color: #fff;
  font-size: 16px;
}
</style>
