<template>
  <article class="wrapper-box">
    <header>
       <div>
        <span>监测设备选择：</span>
        <ZlComboTree :treeData="treeDevice" v-model="selDevice"></ZlComboTree>
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
            <tr v-for="i in 20">
              <td v-for="field in fields"><span><br> </span></td>
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

import { WIRES, SECTIONS } from "../json/json_device_info";

export default {
  components: {
    DashboardBox,
    ZlDatePicker,
    ZlComboTree
  },
  data() {
    return {
      key: 12,
      arr: "",
      treeDevice: [],
      selDevice: null,
      startDate: null,
      endDate: null,
      fields: [
        { name: "wire_name", caption: "告警线路" },
        { name: "fault_handle", caption: "告警时间" },
        { name: "fault_level", caption: "告警类型" },
        { name: "fault_level", caption: "告警级别" },
        { name: "fault_level", caption: "详细描述" }
      ]
    };
  },
  mounted() {
    WIRES.map(wire => {
      this.treeDevice.push({
        name: wire.name,
        label: wire.name_cn,
        type: wire.type
      });
    });
    SECTIONS.map(section => {
      this.treeDevice.push({
        name: section.name,
        label: section.name_cn,
        type: "SECTION"
      });
    });
  },
  methods: {
  }
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
header > div {
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
}

td,
th,
table {
  border: 1px solid #2b4f69;
  font-weight: normal;
}

thead {
  background-color: #06192a;
  line-height: 28px;
}

tbody {
  line-height: 26px;
  text-align: center;
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