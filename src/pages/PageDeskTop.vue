<template>
  <div class="desktop">
  </div>
</template>
<script>
export default {}

</script>
<style scoped>
.desktop {
  position: absolute;
  top: 80px;
  left: 5px;
  right: 5px;
  bottom: 5px;
  background: #000 url("../assets/zxt.png") no-repeat center center;
  background-size: contain;
  border-radius: 10px;
}

.alarm,
.warn {
  position: relative;
  display: inline-block;
  width: 70px;
  height: 20px;
  line-height: 20px;
  text-align: center;
  float: right;
  color: #070707;
  margin-right: 20px;
  border-radius: 2px;
}

.alarm {
  background-color: #C55C60;
}

.warn {
  background-color: #FEE179;
}

.alarm>span,
.warn>span {
  display: inline-block;
  position: absolute;
  background-color: #F56C6C;
  border-radius: 5px;
  top: -5px;
  right: -15px;
  left: auto;
  height: 15px;
  line-height: 15px;
  width: 20px;
  font-size: 6px;
  color: #fff;
}

</style>
