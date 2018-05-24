<template>
  <div class="wrapper-box">
    <Gis></Gis>
    <FaultCount></FaultCount>
    <FaultRecord></FaultRecord>
  </div>
</template>
<script>
import Gis from '../components/desktop/Gis'
import TaskView from '../components/desktop/TaskView'
import FaultCount from '../components/desktop/FaultCount'
import FaultRecord from '../components/desktop/FaultRecord'
export default {
  components: { Gis, TaskView, FaultCount, FaultRecord }
}

</script>
<style scoped>
.wrapper-box>section:nth-child(1) {
  position: absolute;
  top: 10px;
  bottom: 10px;
  left: 10px;
  width: calc(50% - 10px);
  border-radius: 5px;
}

.wrapper-box>section:nth-child(2) {
  position: absolute;
  top: 10px;
  right: 10px;
  width: calc(50% - 15px);
  height: 120px;
  border-radius: 5px;
  background-color: #132D48;
  border: 1px solid #225373;
}

.wrapper-box>section:nth-child(3) {
  position: absolute;
  top: 135px;
  right: 10px;
  width: calc(50% - 15px);
  bottom: 10px;
  border-radius: 5px;
  background-color: #132D48;
  border: 1px solid #225373;
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
