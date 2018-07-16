<template>
  <section class="wrapper">
    <div class="content-box" v-for="device in devices">
      <header>
        {{device.name_cn}}
      </header>
      <div>
        <ul>
          <li v-for="param in device.params" :class="{'content-txt' : param.show_type !='1'}">
            <div v-if="param.show_type=='1'">
              <span>{{param.name_cn}}：</span>
              <span><strong>{{param.val}}</strong>{{param.unit}}</span>
            </div>
            <RadialGauge :param="param" v-else-if="param.show_type=='2'"></RadialGauge>
            <LinearGauge :param="param" v-else-if="param.show_type=='3'"></LinearGauge>
            <SwitchGauge :param="param" v-else-if="param.show_type=='4'"></SwitchGauge>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>
<script>
import LinearGauge from "@/components/LinearGauge";
import RadialGauge from "@/components/RadialGauge";
import SwitchGauge from "@/components/SwitchGauge";
export default {
  components: { LinearGauge, RadialGauge, SwitchGauge },
  props: {
    node: Object
  },
  data() {
    return {
      currentData: [],
      monitor_devices: [],
      monitor_params: []
    }
  },
  computed: {
    devices() {
      let l_devices = []
      /*过滤所有该监测类型参数*/
      let l_params = this.monitor_params.filter(param => param.monitor_type == this.node.monitor_type_name)
      /*获取每个该线路该监测类型设备实时数据*/
      this.monitor_devices.map(device => {
        if (this.node.name == (device.wire ? device.wire : device.section) && device.monitor_type == this.node.monitor_type_name) {
          l_devices.push(device)
          let device_data = this.currentData.find(adata => adata.device_name == device.name)
          device.params = [{
            name_cn: '采集时间',
            val: device_data && device_data['data_time'] ? device_data['data_time'] : '2017-09-09 11:00:02',
            unit: '',
            show_type: 1
          }]
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
  methods: {
    queryData() {
      this.axios.get('/test/real-data').then(response => {
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
    this.axios.get('monitor-devices').then(response => {
      this.monitor_devices = response.data
      return this.axios.get('monitor-params')
    }).then(response => {
      this.monitor_params = response.data
      this.queryData()
    })

    window.setInterval(() => this.queryData(), 2000)
  }
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

</style>
