<template>
  <section class="wrapper">
    <h2>{{this.title}}</h2>
    <section class="data-box">
      <div class="content-box" v-for="(device,index) in devices">
        <header>
          {{device.name_cn}}
        </header>
        <div>
          <ul>
            <li v-for="param in device.params" :class="{'content-txt' : param.show_type !='1'}">
              <div v-if="param.show_type=='1'">
                <span>{{param.name_cn}}：</span>
                <span><strong  :class="device.state">{{param.data_type == 'BOOL'? param.val ==1?'开':'关' : param.val}}</strong>{{param.unit}}</span>
              </div>
              <RadialGauge :param="param" v-else-if="param.show_type=='2'"></RadialGauge>
              <LinearGauge :param="param" v-else-if="param.show_type=='3'"></LinearGauge>
              <SwitchGauge :param="param" v-else-if="param.show_type=='4'"></SwitchGauge>
            </li>
          </ul>
        </div>
        <section v-if="device.state !='good'">
          <PDWave :points="showWave" :title="device.name_cn" type="PRPD" class="wave" v-if="device.monitor_type == 'SPDC'"></PDWave>
          <PDWave :points="showWave" :title="device.name_cn" type="PRPS" class="wave" v-else-if="device.monitor_type == 'GILC'"></PDWave>
          <Video v-else-if="device.monitor_type == 'SPTR'"></Video>
        </section>
      </div>
    </section>
  </section>
</template>
<script>
import LinearGauge from "@/components/LinearGauge";
import RadialGauge from "@/components/RadialGauge";
import SwitchGauge from "@/components/SwitchGauge";
import Video from './Video'
import { mapGetters } from 'vuex'
import { PD_WAVE, PD_WAVE1, PD_WAVE2 } from "@/json/json_pd";
import PDWave from "@/components/PDWave";

import { CUR_STATE } from '@/json/json_monitor_status'
import Qs from "qs";
export default {
  components: { LinearGauge, RadialGauge, SwitchGauge, PDWave, Video },
  props: {
    node: Object
  },
  data() {
    return {
      waves: [PD_WAVE, PD_WAVE1, PD_WAVE2],
      showWave: PD_WAVE1,
      phases: ["A相", "B相", "C相"],
      currentData: []
    }
  },
  computed: {
    ...mapGetters({
      all_devices: 'monitorDevices',
      all_params: 'monitorParams',
      all_types: 'monitorTypes'
    }),
    title() {
      let type = this.all_types.find(type => type.name == this.node.monitor_type_name)
      return this.node.label + '/' + (type ? type.name_cn : '')
    },
    devices() {
      let l_devices = []
      /*过滤所有该监测类型参数*/
      let l_params = this.all_params.filter(param => param.monitor_type == this.node.monitor_type_name)
      /*获取每个该线路该监测类型设备实时数据*/
      this.all_devices.map(device => {
        if (this.node.name == (device.wire ? device.wire : device.section) && device.monitor_type == this.node.monitor_type_name) {
          l_devices.push(device)

          let device_state = CUR_STATE.find(
            state => state.device_name == device.name
          );
          device.state = device_state ? device_state.state : 'good';

          let device_data = this.currentData.find(adata => adata.device_name == device.name)
          device.params = [{
            name_cn: '采集时间',
            val: device_data && device_data['data_time'] ? device_data['data_time'] : '/',
            unit: '',
            show_type: 1
          }]
          l_params.map(param => {
            let l_param = {
              name: param.name,
              name_cn: param.name_cn,
              unit: param.unit,
              show_type: param.show_type,
              data_type: param.data_type,
              val: '/ '
            }
            if (device_data && device_data[param.name]) {
              l_param.val = device_data[param.name]
            }
            device.params.push(l_param)
          })
        }
      })
      return l_devices
    }
  },
  methods: {
    onClickDevice(index) {
      if (index < this.waves.length) {
        this.showWave = this.waves[index]
      }
    },
    queryData() {
      let options = {
        type: this.node.monitor_type_name
      }
      this.axios.get("/test/real-data?" + Qs.stringify(options)).then(response => {
        this.currentData = []
        response.data.map(adata => {
          let old_data = this.currentData.find(item => item.device_name == adata.device_name)
          if (old_data) {
            old_data[adata['param_name']] = adata['val']
          } else {
            this.currentData.push({
              device_name: adata['device_name'],
              data_time: adata['data_time'],
              [adata['param_name']]: adata['val']
            })
          }
        })
      })
    }
  },
  mounted() {
    this.queryData()
    window.setInterval(() => this.queryData(), 120000)
  },
  watch: {
    node(newVal) {     
      this.queryData();
    }
  },
}

</script>
<style scoped>
.wrapper {}

h2 {
  color: #3c3c3c;
  font-size: 26px;
  margin-bottom: 10px;
  font-weight: normal;
}

.data-box {
  padding-left: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;
}

.content-box {
  position: relative;
  font-size: 16px;
  background-color: #38648D;
  margin-bottom: 5px;
  margin-right: 5px;
  padding-bottom: 10px;
  border-radius: 5px;
  cursor: pointer;
}

.content-box>header {
  position: relative;
  text-align: center;
  height: 30px;
  line-height: 30px;
  padding: 10px;
}

.content-box ul {
  /*  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;*/
}

.content-box li {
  display: block;
  padding: 5px;
  font-size: 14px;
}

.content-box>section {
  position: absolute;
  left: -9999px;
  top: -9999px;
  width: 500px;
  height: 320px;
  z-index: 99;
}

.content-box:hover>section {
  left: 300px;
  top: 10px;
}

li.content-txt {
  display: inline-block;
}

li>div {
  padding: 0 10px;
  font-size: 14px;
  width: 300px;
}

li span:first-child {
  color: #ccc;
  display: inline-block;
  width: 100px;
  text-align: right;
}

li span:last-child {
  color: #90DFE4;
}

li strong {
  font-size: 18px;
}

.wave {
  width: calc(100% - 1px);
  height: calc(100% - 1px);
  background-color: #fff;
  border-right: 1px solid #000;
}

</style>
