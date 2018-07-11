<template>
  <section>
    <header>
      <a v-for="monitorType in monitorTypes" :class="monitorType.hideFlg?'unkown':'good'" @click="legendChange(monitorType)">
          <i class="iconfont" :class="monitorType.icon"></i>
            <span>{{monitorType.name_cn}}</span>
      </a>
    </header>
    <div @mouseup="drop" @mousemove="move" ref="wrapper" class="wrapper">
      <img class="bg" src="../../assets/zxt.png">
      <button type="text" :style="{ left:device.positionX + '%' , top:device.positionY  + '%'}" @mousedown.left="grab($event,device)" v-for="device in showDevices">
        <i class="iconfont good" :class="device.icon"></i>
        <span class="good">{{device.name_cn}}</span>
      </button>
    </div>
  </section>
</template>
<script>
import { copyObject } from '@/shared/util'
export default {
  props: {
    value: Array
  },
  data() {
    return {
      monitorTypes: [],
      selectDevice: null,
      cursePoint: null,
    }
  },
  computed: {
    showDevices: {
      get() {
        let result = []
        this.value && this.value.map(device => {
          let monitorType = this.monitorTypes.find(item => !item.hideFlg && item['name'] == device['monitor_type'])
          if (monitorType) {
            let showDevice = copyObject(device)
            showDevice['icon'] = monitorType['icon']
            result.push(showDevice)
          }
        })
        return result
      },
      set(newVal) {
        this.$emit('input', newVal)
      }
    }
  },
  mounted() {
    this.axios.get('monitor-types').then(resp => {
      this.monitorTypes = resp.data.filter(monitorType => monitorType['type'] == 'WIRE_MONITOR')
    })
  },
  methods: {
    legendChange(monitorType) {
      this.$set(monitorType, 'hideFlg', !monitorType.hideFlg)
    },
    grab(e, device) {
      this.selectDevice = device
      this.cursePoint = [e.clientX, e.clientY]
    },
    drop(e) {
      this.selectDevice = null
    },
    move(e) {
      if (this.selectDevice) {
        let wrapper = this.$refs["wrapper"]
        this.selectDevice.positionX = parseFloat(this.selectDevice.positionX) + 100 * (e.clientX - this.cursePoint[0]) / wrapper.clientWidth
        this.selectDevice.positionY = parseFloat(this.selectDevice.positionY) + 100 * (e.clientY - this.cursePoint[1]) / wrapper.clientHeight
        this.cursePoint = [e.clientX, e.clientY]
      }
    }
  }
}

</script>
<style scoped>
section {
  height: 100%;
  background-color: #10406A;
}

header {
  height: 40px;
  line-height: 40px;
  font-size: 16px;
  text-align: center;
  display: flex;
  justify-content: space-around;
}

.iconfont {
  font-size: 20px;
}

.wrapper {
  position: absolute;
  left: 0;
  right: 0;
  top: 40px;
  bottom: 0;
  overflow: hidden;
}

.wrapper img.bg {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.wrapper>button {
  position: absolute;
  width: 20px;
  height: 20px;
  line-height: 20px;
}

.wrapper>button>span {
  position: absolute;
  top: -9999px;
  left: -9999px;
  width: 80px;
}

.wrapper>button:hover span {
  top: 0;
  left: 20px;
}

</style>
