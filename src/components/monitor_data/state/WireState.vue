<template>
  <section class="wrapper">
    <img src="../../../assets/zxt.png">
      <button type="text" :style="{ left:device.positionX + '%' , top:device.positionY  + '%'}"  v-for="device in showDevices">
        <i class="iconfont good icon-circle"></i>
        <span class="good">{{device.name_cn}}</span>
      </button>
  </section>
</template>
<script>
import { MONITOR_DEVICES } from '@/json/json_device_info'
import { MONITOR_TYPES } from '@/json/json_base_info'
export default {
  props: {
    node: Object
  },
  computed:{
    showDevices(){
      return MONITOR_DEVICES.filter(device=> device.monitor_type == this.node.monitor_type_name&&device.wire==this.node.name)
    }
  }
}

</script>
<style scoped>
.wrapper{
  position: absolute;
  left: 10px;
  right: 10px;
  top: 10px;
  bottom: 10px;
  overflow: hidden;
}
img{
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.iconfont {
  font-size: 20px;
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
