<template>
  <article class="wrapper-box">
    <header>
      <div>
        <span>监测设备选择：</span>
         <select v-model="selDeviceName">
          <option v-for="device in treeDevice" :value="device.name">{{device.name_cn}}</option>
        </select>
      </div>
      <div>
        <span>开始时间:</span>
        <ZlDatePicker v-model="startDate"></ZlDatePicker>
      </div>
      <div>
        <span>结束时间:</span>
        <ZlDatePicker v-model="endDate"></ZlDatePicker>
      </div>
      <button type="text"><i class="iconfont icon-search"></i></button>
    </header>
    <section>
      <div>
        <table>
          <thead>
            <tr>
              <th v-for="field in fields">{{field.caption}}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row,row_id) in data" :class="row.level==1?'warn':'bad'">
              <td v-for="field in fields">
                <span>{{row[field.name]}}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <footer>
        <div>
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
        </div>
      </footer>
    </section>
  </article>
</template>
<script>
import DashboardBox from "../components/DashboardBox";
import ZlDatePicker from "../components/ZlDatePicker";
import ZlComboTree from "../components/ZlComboTree";

import { mapGetters } from 'vuex'

import {
  ALARM_RECORDS
} from "@/json/json_event";

export default {
  components: {
    DashboardBox,
    ZlDatePicker,
    ZlComboTree
  },
  data() {
    return {
      key: 12,
      selDeviceName: "",
      startDate: (new Date).addMonths(-1),
      endDate: new Date(),
      fields: [
        { name: "name", caption: "告警线路" },
        { name: "time", caption: "告警时间" },
        { name: "type", caption: "告警类型" },
        { name: "level_desc", caption: "告警级别" },
        { name: "detail", caption: "详细描述" },
        { name: "state", caption: "状态" },
      ],
      data: ALARM_RECORDS
    };
  },

  computed: {
    ...mapGetters({
      wires: 'wires',
      sections: "sections",
    }),
    treeDevice() {
      let ret = []
      this.wires.map(wire => {
        ret.push({
          name: wire.name,
          name_cn: wire.name_cn,
          type: wire.type
        });
      });
      this.sections.map(section => {
        ret.push({
          name: section.name,
          name_cn: section.name_cn,
          type: "SECTION"
        });
      });
      if (ret && ret.length)
        this.selDeviceName = ret[0]["name"]
      return ret
    }
  },
  mounted() {

  },
  methods: {}
};

</script>
<style scoped>
header {
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px;
  background-color: #132d48;
}

header>div {
  margin-right: 20px;
}

header select {
  width: 200px;
}

section {
  position: relative;
  height: calc(100% - 60px);
  background-color: #ccc;
  background-color: #132d48;
  border: solid 1px #406985;
  overflow: hidden;
}

footer {
  position: absolute;
  bottom: 0;
  left: 0;
  top: auto;
  right: 0;
  height: 30px;
  line-height: 30px;
  background-color: #133551;
  padding-left: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
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

td:last-child {
  color: #28A646;
}

a {
  color: #28A646;
}

footer div {
  margin-right: 50px;
  float: left;
}

footer input {
  width: 16px;
  text-align: center;
}

.iconfont {
  color: #fff;
  font-size: 20px;
}

.wave {
  position: absolute;
  top: 50px;
  left: 50px;
  height: 300px;
  width: 400px;
  background-color: #fff;
}

</style>
