<template>
  <section>
    <div @mouseup="drop" @mousemove="move" ref="wrapper" class="wrapper">
      <img class="bg" src="../../assets/zxt.png">
      <button type="text" :style="{ left:device.positionX + '%' , top:device.positionY  + '%'}" @mousedown.left="grab($event,device)" v-for="device in showDevices">
        <i class="iconfont good icon-camera"></i>
        <span class="good">{{device.name_cn}}</span>
      </button>
    </div>
  </section>
</template>
<script>
import { MONITOR_CAMERAS } from '../../json/json_device_info'
export default {
  data() {
    return {
      showDevices: [],
      selectDevice: null,
      cursePoint: null,
    }
  },
  mounted() {
    this.showDevices = MONITOR_CAMERAS
  },
  methods: {
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
        this.selectDevice.positionX = this.selectDevice.positionX + 100 * (e.clientX - this.cursePoint[0]) / wrapper.clientWidth
        this.selectDevice.positionY = this.selectDevice.positionY + 100 * (e.clientY - this.cursePoint[1]) / wrapper.clientHeight
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

.iconfont {
  font-size: 20px;
}

.wrapper {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
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
