<template>
  <section>
    <div v-for="phase in phases" class="state-box">
      <ul>
        <li v-for="section in sections" :style="{width: 100 / sections.length + '%'}">
          <span>{{section.name_cn}}</span>
          <template v-for="device in devices">
            <button type="text" v-if="device.section == section.name && device.phase == phase">
              <i class="iconfont icon-circle good"></i>
            </button>
          </template>
        </li>
      </ul>
    </div>
  </section>
</template>
<script>
import { MONITOR_DEVICES } from '../../../json/json_device_info'
import { SECTIONS } from '../../../json/json_device_info'
export default {
  props: {
    node: Object
  },
  data() {
    return {
      currentState: [],
      sections: SECTIONS,
      phases: ['A相', 'B相', 'C相']
    }
  },
  computed: {
    devices() {
      let l_devices = []
      /*获取每个该线路该监测类型设备实时状态*/
      MONITOR_DEVICES.map(device => {
        if (device.wire == this.node.name && device.monitor_type == this.node.monitor_type_name) {
          l_devices.push(device)
          let device_sate = this.currentState.find(state => state.device_name == device.name)
          device.state = device_sate ? device_sate.state : null
        }
      })
      return l_devices
    }
  },
}

</script>
<style scoped>
section {
  padding-left: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;
}

.state-box {
  width: 100%;
  height: 30px;
  margin: 10% 5px 0 5px;
  position: relative;
}

.state-box ul {
  width: calc(100% -70px);
  /*background-color: #DAEAF7;*/
  background-color: #3C3C3C;
  height: 3px;
  margin-left: 70px;
  border-radius: 3px;
  /*border: 1px solid #CED4DF;*/
  display: flex;
  justify-content: space-around;
}

.state-box:before {
  position: absolute;
  top: -50%;
  transform: translateY(50%);
  left: 30px;
  color: #3C3C3C;
}

.state-box:nth-child(3n + 1):before {
  content: 'A相';
}

.state-box:nth-child(3n + 2):before {
  content: 'B相';
}

.state-box:nth-child(3n):before {
  content: 'C相';
}

.state-box:nth-child(3n) {
  margin-bottom: 100px;
}

.state-box li {
  float: left;
  position: relative;
  height: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.state-box li:after {
  content: '';
  border-left: dashed 3px #999;
  height: 100px;
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
  color: #3C3C3C;
}

</style>
