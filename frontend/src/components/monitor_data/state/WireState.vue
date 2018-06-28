<template>
  <article class="wrapper">
    <section class="state-box" :class="{'pd-box':node.monitor_type_name =='SPDC'}">
      <img src="../../../assets/zxt.png">
      <div :style="{ left:device.positionX + '%' , top:device.positionY  + '%'}" v-for="device in showDevices">
        <button type="text"> 
          <i class="iconfont good icon-circle"></i>
        </button>
        <ul>
          <li v-for="param in device.params">
            <span>{{param.name_cn}}：</span>
            <span><strong>{{param.val}}</strong>{{param.unit}}</span>
          </li>
        </ul>
      </div>
    </section>
    <section class="wave-box" v-if="node.monitor_type_name =='SPDC'">
       <PDWave :points="wave" :title="phases[index]" type="PRPD" class="wave" v-for="(wave,index) in waves"></PDWave>
    </section>
  </article>
</template>
<script>
import PDWave from "@/components/PDWave";
import { MONITOR_DEVICES } from "@/json/json_device_info";
import { MONITOR_TYPES } from "@/json/json_base_info";
import { PD_WAVE, PD_WAVE1, PD_WAVE2 } from "@/json/json_pd";
import { MONITOR_PARAMS } from "../../../json/json_base_info";
import { CUR_DATA } from "@/json/json_monitor_data";
export default {
  components: { PDWave },
  props: {
    node: Object
  },
  data() {
    return {
      waves: [PD_WAVE, PD_WAVE1, PD_WAVE2],
      currentData: CUR_DATA,
      phases: ["A相", "B相", "C相"]
    };
  },
  computed: {
    showDevices() {
      let l_devices = [];
      /*过滤所有该监测类型参数*/
      let l_params = MONITOR_PARAMS.filter(
        param => param.monitor_type == this.node.monitor_type_name
      );
      /*获取每个该线路该监测类型设备实时数据*/
      MONITOR_DEVICES.map(device => {
        if (
          this.node.name == (device.wire ? device.wire : device.section) &&
          device.monitor_type == this.node.monitor_type_name
        ) {
          l_devices.push(device);
          let device_data = this.currentData.find(
            adata => adata.device_name == device.name
          );
          device.params = [];
          l_params.map(param => {
            let l_param = {
              name: param.name,
              name_cn: param.name_cn,
              unit: param.unit,
              show_type: param.show_type,
              val: "/ "
            };
            if (device_data && device_data[param.name]) {
              l_param.val = device_data[param.name];
            }
            device.params.push(l_param);
          });
        }
      });
      return l_devices;
    }
  }
};
</script>
<style scoped>
.wrapper {
  position: absolute;
  left: 10px;
  right: 10px;
  top: 10px;
  bottom: 10px;
  overflow: hidden;
}
.state-box {
  width: 100%;
  height: 100%;
  position: relative;
}
.pd-box {
  height: 60%;
}
.state-box img {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.iconfont {
  font-size: 20px;
}
.state-box > div {
  position: absolute;
  line-height: 20px;
}
.state-box ul {
  position: absolute;
  top: 0;
  left: -9999px;
  width: 300px;
}

.state-box > div:hover ul {
  left: 30px;
}

.wave-box {
  position: absolute;
  top: 60%;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  align-items: center;
  align-content: space-between;
}
.wave {
  width: calc(33% - 1px);
  height: calc(100% - 1px);
  background-color: #fff;
  border-right: 1px solid #000;
}
</style>
