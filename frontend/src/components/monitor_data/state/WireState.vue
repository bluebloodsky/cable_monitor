<template>
  <section class="wrapper">
    <img src="../../../assets/zxt.png">
    <div :style="{ left:device.positionX + '%' , top:device.positionY  + '%'}" v-for="device in showDevices">
      <button type="text"> 
        <i class="iconfont good icon-circle"></i>
      </button>
      <ul>
        <li> 
      <span>视在局放：12pC</span>
        </li>
        <li> 
      <span>放电次数：20</span>
        </li>
      </ul>
    </div>
  </section>
</template>
<script>
import { MONITOR_DEVICES } from "@/json/json_device_info";
import { MONITOR_TYPES } from "@/json/json_base_info";
export default {
  props: {
    node: Object
  },
  computed: {
    showDevices() {
      return MONITOR_DEVICES.filter(
        device =>
          device.monitor_type == this.node.monitor_type_name &&
          device.wire == this.node.name
      );
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
img {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.iconfont {
  font-size: 20px;
}
.wrapper > div {
  position: absolute;
  line-height: 20px;
}
.wrapper ul {
  position: absolute;
  top: 0;
  left: 30px;
  width: 300px;
}
</style>
