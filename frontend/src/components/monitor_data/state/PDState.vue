<template>
  <article class="wrapper">
    <section class="state-box">
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
    <section class="wave-box">
       <PDWave :points="wave" type="PRPD" class="wave" v-for="wave in waves"></PDWave>
    </section>
  </article>
</template>
<script>
import PDWave from "@/components/PDWave";
import { MONITOR_DEVICES } from "@/json/json_device_info";
import { MONITOR_TYPES } from "@/json/json_base_info";
import { PD_WAVE, PD_WAVE1, PD_WAVE2 } from "@/json/json_pd";

export default {
  components:{PDWave},
  props: {
    node: Object
  },
  data(){
    return {
         waves: [PD_WAVE, PD_WAVE1, PD_WAVE2],
    }
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
.state-box{
  width: 100%;
  height: 60%;
  position: relative;
}
.state-box img {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.iconfont {
  font-size: 20px;
}
.state-box > div {
  position: absolute;
  line-height: 20px;
}
.state-box ul {
  position: absolute;
  top: 0;
  left: 30px;
  width: 300px;
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
  justify-content: space-around;
  align-items: center;
  align-content: space-between;
}
.wave {
  width: calc(33% - 1px);
  height: calc(100% - 1px);
  background-color: #fff;
  border-right: 1px solid #000;
}
</style>
