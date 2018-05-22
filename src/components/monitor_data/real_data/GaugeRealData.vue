<template>
  <section class="wrapper">
    <div class="content-box" v-for="device in devices">
      <header>
        {{device.name_cn}}
      </header>
      <div>
        <ul>
          <li v-for="param in device.params">
            <LinearGauge :param="param" v-if="param.show_type=='Linear'"></LinearGauge>
            <RadialGauge :param="param" v-else></RadialGauge>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>
<script>
import LinearGauge from "@/components/LinearGauge";
import RadialGauge from "@/components/RadialGauge";
import { MONITOR_DEVICES } from '../../../json/json_device_info'
import { MONITOR_PARAMS } from '../../../json/json_base_info'
export default {  
  components: { LinearGauge, RadialGauge },
  props: {
    node: Object
  },
  data() {
    return {
      currentData: []
    }
  },
  computed: {
    devices() {
      let l_devices = []
      /*过滤所有该监测类型参数*/
      let l_params = MONITOR_PARAMS.filter(param => param.monitor_type == this.node.monitor_type_name)
      /*获取每个该线路该监测类型设备实时数据*/
      MONITOR_DEVICES.map(device => {
        if (this.node.name == (device.wire ? device.wire : device.section) && device.monitor_type == this.node.monitor_type_name) {
          l_devices.push(device)
          let device_data = this.currentData.find(adata => adata.device_name == device.name)
          device.params = []
          l_params.map(param => {
            let l_param = {
              name: param.name,
              name_cn: param.name_cn,
              unit: param.unit,
              show_type: param.show_type,
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
  mounted() {}
}

</script>
<style scoped>
.wrapper {
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
}
.content-box>header {
  position: relative;
  text-align: center;
  height: 30px;
  line-height: 30px;
  padding: 10px;
}

.content-box ul{
  display: flex;
  justify-content: space-around;
  align-items: center;
}
.content-box li {
  display: block;
  padding: 5px;
  font-size: 14px;
  float: left;
}

p{
  text-align: center;
}
</style>
