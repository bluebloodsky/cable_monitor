<template>
  <div class="wrapper-box">
    <!-- <DashboardBox title="概况信息统计">
      <GeneralInfo></GeneralInfo>
    </DashboardBox> -->
    <DashboardBox title="视频监控">
      <Camera></Camera>
    </DashboardBox>
    <DashboardBox title="GIS">
      <Gis></Gis>
    </DashboardBox>
    <DashboardBox title="告警统计">
      <FaultCount></FaultCount>
    </DashboardBox>
    <DashboardBox title="告警记录">
      <FaultRecord></FaultRecord>
    </DashboardBox>
  </div>
</template>
<script>
import DashboardBox from "../components/DashboardCard";
import GeneralInfo from "../components/desktop/GeneralInfo";
import Camera from "../components/desktop/Camera";
import Gis from "../components/desktop/Gis";
import TaskView from "../components/desktop/TaskView";
import FaultCount from "../components/desktop/FaultCount";
import FaultRecord from "../components/desktop/FaultRecord";
export default {
  components: { DashboardBox, GeneralInfo, Camera, Gis, TaskView, FaultCount, FaultRecord }
};

</script>
<style scoped>
.wrapper-box>article:nth-child(1) {
  position: absolute;
  left: 10px;
  top: 10px;
  right: 75%;
  bottom: 20px;
  /* height: calc(50% + 10px); */
  width: auto;
}

/* .wrapper-box>article:nth-child(2) {
  position: absolute;
  left: 10px;
  top: auto;
  right: 75%;
  bottom: 20px;
  height: calc(50% - 50px);
  width: auto;
} */

.wrapper-box>article:nth-child(2) {
  position: absolute;
  left: calc(25% + 10px);
  top: 10px;
  bottom: 20px;
  right: calc(25% + 100px);
  width: auto;
  height: auto;
}

.wrapper-box>article:nth-child(3) {
  position: absolute;
  left: calc(75% - 90px);
  top: 10px;
  right: 10px;
  bottom: auto;
  height: 200px;
  width: auto;
}

.wrapper-box>article:nth-child(4) {
  position: absolute;
  left: calc(75% - 90px);
  top: 250px;
  right: 10px;
  bottom: 20px;
  width: auto;
}




/*
.wrapper-box > article:nth-child(1) {
  position: absolute;
  top: 10px;
  bottom: 10px;
  left: 10px;
  width: calc(50% - 20px);
}

.wrapper-box > article:nth-child(2) {
  position: absolute;
  top: 10px;
  right: 10px;
  width: calc(50% - 20px);
  height: 180px;
}

.wrapper-box > article:nth-child(3) {
  position: absolute;
  top: 230px;
  right: 10px;
  width: calc(50% - 20px);
  bottom: 10px;
}
*/

</style>
