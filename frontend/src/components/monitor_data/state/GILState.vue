<template>
  <section class="wrapper">
    <div v-for="phase in phases" class="state-box">
      <ul>
        <li v-for="section in sections" :style="{width: 100 / sections.length + '%'}">
          <span>{{section.name_cn}}</span>
          <template v-for="device in devices">
            <button type="text" v-if="device.section == section.name && device.phase == phase" @click="showWave">
              <i class="iconfont icon-circle good"></i>
            </button>
          </template>
        </li>
      </ul>
    </div>
    <hr>
    <div class="wave-box">
      <PDWave :points="wave" :type="PRPS" class="wave" v-for="wave in waves"></PDWave>
    </div>
  </section>
</template>
<script>
import { MONITOR_DEVICES } from "../../../json/json_device_info";
import { SECTIONS } from "../../../json/json_device_info";
import PDWave from "@/components/PDWave";
import { PD_WAVE, PD_WAVE1, PD_WAVE2 } from "@/json/json_pd";
export default {
  components: { PDWave },
  props: {
    node: Object
  },
  data() {
    return {
      currentState: [],
      sections: SECTIONS,
      phases: ["A相", "B相", "C相"],
      waves: [PD_WAVE, PD_WAVE1, PD_WAVE2 , PD_WAVE],
      showWaveFlg: false
    };
  },
  computed: {
    devices() {
      let l_devices = [];
      /*获取每个该线路该监测类型设备实时状态*/
      MONITOR_DEVICES.map(device => {
        if (
          device.wire == this.node.name &&
          device.monitor_type == this.node.monitor_type_name
        ) {
          l_devices.push(device);
          let device_sate = this.currentState.find(
            state => state.device_name == device.name
          );
          device.state = device_sate ? device_sate.state : null;
        }
      });
      return l_devices;
    }
  },
  methods: {
    showWave() {
      this.showWaveFlg = true;
    },
    hideWave() {
      this.showWaveFlg = false;
    }
  }
};
</script>
<style scoped>
.wrapper {
  padding-left: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;
  height: 100%;
}

.state-box {
  width: 100%;
  height: 20%;
  position: relative;
}

.state-box ul {
  width: calc(100% -70px);
  background-color: #3c3c3c;
  height: 3px;
  margin-left: 70px;
  margin-top: 5%;
  transform: translateY(-50%);

  border-radius: 3px;
  /*border: 1px solid #CED4DF;*/
  display: flex;
  justify-content: space-around;
}

.state-box:before {
  position: absolute;
  top: 0;
  margin-top: 5%;
  transform: translateY(-50%);
  left: 20px;
  font-size: 16px;
}

.state-box:nth-child(3n + 1):before {
  content: "A相";
  color: yellow;
}

.state-box:nth-child(3n + 2):before {
  content: "B相";
  color: green;
}

.state-box:nth-child(3n):before {
  content: "C相";
  color: red;
}

/*.state-box:nth-child(3n) {
  margin-bottom: 100px;
}*/

.state-box li {
  float: left;
  position: relative;
  height: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.state-box li:after {
  content: "";
  border-left: dashed 3px #999;
  height: 80px;
  width: 0;
  position: absolute;
  right: 0;
  bottom: -8px;
  left: auto;
  top: auto;
}

.state-box li span {
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  color: #3c3c3c;
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
  justify-content: space-between;
  align-items: center;
  align-content: space-between;
}
.wave {
  width: calc(25% - 1px);
  height: calc(100% - 1px);
  background-color: #fff;
  border-right: 1px solid #000;
}
</style>
