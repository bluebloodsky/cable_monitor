<!-- deprecated -->
<template>
  <section>
    <div class="content-box" v-for="device in devices">
      <header>
        {{device.name_cn}}
      </header>
      <div>
        <ul>
          <li v-for="param in device.params">
            <span>{{param.name_cn}}：</span>
            <span><strong>{{param.val}}</strong>{{param.unit}}</span>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>
<script>
import { MONITOR_DEVICES } from '../../../json/json_device_info'
import { MONITOR_PARAMS } from '../../../json/json_base_info'
import { CUR_DATA } from '@/json/json_monitor_data'
export default {
  props: {
    node: Object
  },
  data() {
    return {
      currentData: CUR_DATA
    }
  },
  computed: {
    devices() {
      let l_devices = []
      /*过滤所有该监测类型参数*/
      let l_params = MONITOR_PARAMS.filter(param => param.monitor_type == this.node.monitor_type_name)
      /*获取每个该线路该监测类型设备实时数据*/
      MONITOR_DEVICES.map(device => {
        if (device.wire == this.node.name && device.monitor_type == this.node.monitor_type_name) {
          l_devices.push(device)
          let device_data = this.currentData.find(adata => adata.device_name == device.name)
          device.params = [{
            name_cn: '采集时间',
            val: device_data && device_data['data_time'] ? device_data['data_time'] : '/',
            unit: ''
          }]
          l_params.map(param => {
            let l_param = {
              name: param.name,
              name_cn: param.name_cn,
              unit: param.unit,
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
section {
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
  width: 300px;
  padding-bottom: 10px;
  border-radius: 5px;
}


.content-box>header {
  position: relative;
  text-align: center;
  height: 30px;
  line-height: 30px;
}

.content-box li {
  display: block;
  padding: 5px 15px;
  font-size: 14px;
}

.content-box li span:first-child {
  color: #ccc;
  display: inline-block;
  /* width: 60%; */
  text-align: right;
}

.content-box li span:last-child {
  color: #90DFE4;
}

.content-box li strong {
  font-size: 18px;
}

</style>
