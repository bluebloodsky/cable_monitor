<template>
    <section class="wrapper">
      <header>
        <div>
        <span>监测设备选择：</span>
        <select>
          <option>12</option>
        </select>
        </div>
        <div>
        <span>开始时间:</span>
        <ZlDatePicker></ZlDatePicker>  
        </div>
        <div>
        <span>结束时间:</span>
        <ZlDatePicker></ZlDatePicker>  
        </div>
      </header>
        <div class="box left-box">
          <header><span>历史趋势</span></header>
          <div ref="container">  </div>
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
            <td v-for="field in fields"><span>1</span></td>
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
import ZlDatePicker from '../../ZlDatePicker'
import echarts from "echarts";
export default {
  components:{ZlDatePicker},
  data() {
    return {
      chart: null,
      fields: [
        { name: "wire_name", caption: "采集时间" },
        { name: "fault_handle", caption: "视在局放电量(pC)" },
        { name: "fault_level", caption: "是否告警" }
      ]
    };
  },
  mounted() {
    this.chart = echarts.init(this.$refs["container"]);
    let option = {
      title: {
        text: "告警类型趋势",
        textStyle: {
          color: "#fff"
        }
      },
      tooltip: {
        trigger: "axis"
      },
      legend: {
        orient: "vertical",
        x: "right",
        textStyle: {
          color: "#fff"
        },
        data: ["人员闯入", "氧气浓度过低", "天然气泄漏"]
      },
      grid: {
        left: "3%",
        right: "4%",
        top: "25%",
        bottom: "3%",
        containLabel: true
      },
      xAxis: {
        type: "category",
        boundaryGap: false,
        axisLabel: {
          color: "#fff"
        },
        axisLine: {
          lineStyle: {
            color: "#fff"
          }
        },
        data: ["4-11", "4-12", "4-13", "4-14", "4-15", "4-16", "4-17"]
      },
      yAxis: {
        axisLabel: {
          color: "#fff"
        },
        axisLine: {
          lineStyle: {
            color: "#fff"
          }
        },
        type: "value"
      },
      series: [
        {
          name: "人员闯入",
          type: "line",
          stack: "总量",
          data: [0, 0, 0, 1, 0, 0, 0]
        },
        {
          name: "氧气浓度过低",
          type: "line",
          stack: "总量",
          data: [0, 0, 0, 0, 0, 0, 1]
        },
        {
          name: "天然气泄漏",
          type: "line",
          stack: "总量",
          data: [0, 1, 0, 1, 0, 0, 1]
        }
      ]
    };
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

section > header{
  height: 40px;
  background-color: #ccc;
  display:flex;
  justify-content: space-around;
  align-items: center;
  margin-bottom: 10px;
  background-color: #132D48;
}

.left-box,
.right-box {
  float: left;
  width: calc(50% - 5px);
  margin-right: 5px;
  height: calc(100% - 50px);
  background-color: #ccc;
  background-color: #132D48;
  border: solid 1px #406985;
}
div>header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  padding-left: 20px;
  background-color: #1e364e;
  border-bottom: 1px solid #406985;
  margin-bottom: 3px;
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

footer span {
  margin-right: 50px;
}

footer div {
  margin-right: 50px;
  float: left;
}

footer  input {
  width: 16px;
  text-align: center;
}

footer .iconfont {
  color: #fff;
}
</style>