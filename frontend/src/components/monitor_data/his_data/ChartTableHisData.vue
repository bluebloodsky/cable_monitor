<template>
  <section class="wrapper">
    <header>
      <div>
        <span>监测设备选择：</span>
        <select v-model="selDeviceName">
          <option v-for="device in devices" :value="device.name">{{device.name_cn}}</option>
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
      <button type="text" @click="queryData"><i class="iconfont icon-search"></i></button>
    </header>
    <div class="box left-box">
      <header><span>历史趋势</span></header>
      <div ref="container"> </div>
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
            <tr v-for="adata in showData">
              <td v-for="field in fields"><span>{{ field.data_type=='BOOL'? adata[field.name] ==1?'开':'关' :adata[field.name] }} </span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <footer>
        <div>
          <button type="text" @click="cur_page = 1">
            <i class="iconfont icon-angle-double-left"></i>
          </button>
          <button type="text" @click="cur_page>1?cur_page--:cur_page">
            <i class="iconfont icon-return"></i>
          </button>
          <input v-model="cur_page">
          <button type="text" @click="cur_page<totPages?cur_page++:cur_page">
            <i class="iconfont icon-enter"></i>
          </button>
          <button type="text" @click="cur_page=totPages">
            <i class="iconfont icon-angle-double-right"></i>
          </button>
          <span> 共{{totPages}}页 {{his_data.length}}条</span>
        </div>
      </footer>
    </div>
  </section>
</template>
<script>
import ZlDatePicker from "../../ZlDatePicker";
import echarts from "echarts";
import Qs from "qs";
export default {
  props: {
    node: Object
  },
  components: {
    ZlDatePicker
  },
  data() {
    return {
      chart: null,
      startDate: new Date().addMonths(-1).format("yyyy-MM-dd"),
      endDate: new Date().addDays(1).format("yyyy-MM-dd"),
      selDeviceName: "",
      all_devices: [],
      all_params: [],
      chartOption: null,
      his_data: [],
      cur_page: 1,
      num_per_page: 20
    };
  },
  computed: {
    devices() {
      return this.all_devices.filter(device => {
        return device.monitor_type == this.node.monitor_type_name &&
          (this.node.type == "SECTION" ? device.section == this.node.name : device.wire == this.node.name)
      })
    },
    params() {
      return this.all_params.filter(
        param => param.monitor_type == this.node.monitor_type_name
      )
    },
    fields() {
      let result = [{
        name: "data_time",
        caption: "采集时间"
      }]
      this.params.map(param => {
        result.push({
          name: param.name,
          caption: param.name_cn + (param.unit ? "(" + param.unit + ")" : ""),
          data_type: param.data_type
        })
      })
      return result
    },
    totPages() {
      return Math.ceil(this.his_data.length / this.num_per_page);
    },
    showData() {
      return this.his_data.slice(
        this.num_per_page * (this.cur_page - 1),
        this.num_per_page * this.cur_page
      );
    }
  },
  mounted() {
    this.chart = echarts.init(this.$refs["container"]);
    this.axios("monitor-devices").then(response => {
      this.all_devices = response.data
      return this.axios("monitor-params")
    }).then(response => {
      this.all_params = response.data
      this.selDeviceName = this.devices[0].name
      this.queryData();
    })
    window.addEventListener("resize", () => {
      this.chart.resize();
    });
  },
  watch: {
    node(newVal) {
      this.selDeviceName = this.devices[0].name
      this.chart.clear()
      this.queryData();
    }
  },
  methods: {
    queryData() {
      let search_options = {
        device_name: this.selDeviceName,
        time_min: this.startDate.replace(/\D/g, ""),
        time_max: this.endDate.replace(/\D/g, "")
      };
      this.axios.get("/test/his-data?" + Qs.stringify(search_options))
        .then(resp => {
          this.his_data = []
          resp.data.map(adata => {
            let old_data = this.his_data.find(
              item => item.data_time == adata.data_time
            )
            if (old_data) {
              old_data[adata["param_name"]] = adata["val"];
            } else {
              this.his_data.push({
                device_name: adata["device_name"],
                data_time: adata["data_time"],
                [adata["param_name"]]: adata["val"]
              })
            }
          })
          let l_d = this.params.map(param => param.name_cn);
          let series = this.params.map(param => {
            return {
              name: param.name_cn,
              type: "line",
              data: this.his_data.map(adata => adata[param.name])
            };
          });
          let option = {
            color:['#c23531', '#61a0a8', '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
            tooltip: {
              trigger: "axis"
            },
            legend: {
              orient: "horizontal",
              x: "right",
              textStyle: {
                color: "#fff"
              },
              data: l_d
            },
            grid: {
              left: "3%",
              right: "4%",
              top: "10%",
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
              data: this.his_data.map(adata => adata["data_time"])
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
            series: series
          }
          this.chart.setOption(option)
        });
    }
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

section>header {
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px;
  background-color: #132d48;
}

section>header>div {
  margin-right: 20px;
}

section>div {
  float: left;
  width: 50%;
  height: calc(100% - 50px);
  background-color: #ccc;
  background-color: #132d48;
  border: solid 1px #406985;
  overflow: hidden;
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

section>header select {
  width: 200px;
}

.box>div {
  width: 100%;
  height: calc(100% - 40px);
  overflow-y: auto;
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
  font-size: 16px;
}

td,
th,
table {
  border: 1px solid #2b4f69;
  font-weight: normal;
}

thead {
  background-color: #06192a;
  line-height: 36px;
}

tbody {
  line-height: 30px;
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

</style>
