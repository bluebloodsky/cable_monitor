<template>
  <section class="wrapper">
    <h2>{{this.title}}</h2>
    <section class="data-box">
      <div v-for="(phase,phaseIndex) in phases" class="state-box">
        <ul>
          <li v-for="section in sections" :style="{width: 100 / sections.length + '%'}">
            <span>{{section.name_cn}}</span>
            <template v-for="device in devices">
              <section v-if="device.section == section.name && device.phase == phaseIndex + 1" @click="chooseDevice(device)">
                <i class="iconfont icon-circle" :class="device.state"></i>
                <span>{{device.name_cn}}</span>
              </section>
            </template>
          </li>
        </ul>
      </div>
    </section>
  </section>
</template>
<script>
import { mapGetters } from 'vuex'
import { CUR_STATE } from '@/json/json_monitor_status'
export default {
  props: {
    node: Object
  },
  data() {
    return {
      currentState: CUR_STATE,
      phases: ["A相", "B相", "C相"],
      showWaveFlg: false
    };
  },
  computed: {
    ...mapGetters({
      tunnels: 'tunnels',
      wires: 'wires',
      sections: "sections",
      monitor_devices: "monitorDevices",
      all_types: "monitorTypes"
    }),
    title() {
      let type = this.all_types.find(type => type.name == this.node.monitor_type_name)
      return this.node.label + '/' + (type ? type.name_cn : '')
    },
    devices() {
      let l_devices = [];
      /*获取每个该线路该监测类型设备实时状态*/
      this.monitor_devices.map(device => {
        if (
          device.wire == this.node.name &&
          device.monitor_type == this.node.monitor_type_name
        ) {
          l_devices.push(device);
          let device_state = this.currentState.find(
            state => state.device_name == device.name
          );
          device.state = device_state ? device_state.state : 'good';
        }
      });
      return l_devices;
    },
    waveDevices() {
      if (this.devices && this.devices.length) {
        return this.devices.slice(0, 3)
      }

      return []
    }
  },
  methods: {
    chooseDevice(device) {
      this.$emit('choose-device', device)
    }
  }
};

</script>
<style scoped>
.wrapper {
  height: 100%;
  width: 100%;
}

h2 {
  color: #3c3c3c;
  font-size: 26px;
  margin-bottom: 10px;
  font-weight: normal;
}

.data-box {
  padding-left: 20px;
  padding-right: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: center;
  height: calc(100% - 100px);
}

.state-box {
  width: 100%;
  height: 25%;
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

.state-box li>span {
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  color: #3c3c3c;
}

.state-box li>section {
  position: relative;
  cursor: pointer;
}

.state-box li>section>span {
  position: absolute;
  left: -10px;
  width: 40px;
  color: #3c3c3c;
}

</style>
