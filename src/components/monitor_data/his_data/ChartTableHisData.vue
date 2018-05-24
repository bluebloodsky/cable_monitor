<template>
    <section class="wrapper">
        <div class="box left-box" >
          <header><span>历史趋势</span></header>
          <div ref="container"></div>
        </div>
        <div class="box right-box">
          <header><span>数据详情</span></header>
          <div>
      <table>
        <thead>
          <tr>
            <th v-for="field in fields">{{field.caption}}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="i in 4">
            <td v-for="field in fields"><span></span></td>
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
        </div>
    </section>
</template>
<script>
import echarts from "echarts";
export default {
  data() {
    return {
      chart: null,
      fields: [
        { name: "wire_name", caption: '采集时间' },
        { name: 'fault_handle', caption: '视在局放电量(pC)' },
        { name: 'fault_level', caption: '是否告警' },
      ]
    };
  },
  mounted() {
    let option = {
      xAxis: {
        type: "category",
        data: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
      },
      yAxis: {
        type: "value"
      },
      series: [
        {
          data: [820, 932, 901, 934, 1290, 1330, 1320],
          type: "line"
        }
      ]
    };
    this.chart = echarts.init(this.$refs["container"]);
    this.chart.setOption(option);
    window.addEventListener("resize", () => {
      this.chart.resize();
    });
  }
};
</script>
<style scoped>
.wrapper {
  position: absolute;
  top: 10px;
  left: 10px;
  right: 10px;
  bottom: 10px;
}

.box {
  float: left;
  width: calc(50% - 5px);
  margin-right: 5px;
  height: 100%;
  background-color: #ccc;
  border: solid 1px #406985;
}
header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  padding-left: 20px;
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
  border-top: 16px solid #cfdee9;
  border-right: 16px solid transparent;
}

.box > div {
  width: 100%;
  height: calc(100% - 40px);
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
  border: 1px solid #2B4F69;
  font-weight: normal;
}

thead {
  background-color: #06192A;
  line-height: 28px;
}

tbody {
  line-height: 26px;
  text-align: center;
}

a {
  color: #DFF789;
  text-decoration: underline;
}


span {
  margin-right: 50px;
}


footer div {
  margin-right: 50px;
  float: left;
}

input {
  width: 16px;
  text-align: center;
}

.iconfont {
  color: #fff;
}

</style>