<template>
  <div class="wrapper-box">
    <DashboardBox title="GIS导航">
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
import DashboardBox from "../components/DashboardBox";
import Gis from "../components/desktop/Gis";
import TaskView from "../components/desktop/TaskView";
import FaultCount from "../components/desktop/FaultCount";
import FaultRecord from "../components/desktop/FaultRecord";
export default {
  components: { DashboardBox, Gis, TaskView, FaultCount, FaultRecord }
};
</script>
<style scoped>
.wrapper-box > article:nth-child(1) {
  position: absolute;
  top: 10px;
  bottom: 10px;
  left: 10px;
  width: calc(50% - 80px);
  border-radius: 5px;
}

.wrapper-box > article:nth-child(2) {
  position: absolute;
  top: 10px;
  right: 10px;
  width: calc(50% - 100px);
  height: 120px;
  border-radius: 5px;
  /* background-color: #132d48; */
}

.wrapper-box > article:nth-child(3) {
  position: absolute;
  top: 220px;
  right: 10px;
  width: calc(50% - 100px);
  bottom: 10px;
  border-radius: 5px;
  /* background-color: #132d48; */
}
/*
.wrapper-box>section:nth-child(4) {
  position: absolute;
  top: calc(45% + 140px);
  right: 10px;
  width: calc(50% - 15px);  
  bottom: 10px;
  border-radius: 5px;
  background-color: #132D48;
  border: 1px solid #225373;
}
*/
</style>
