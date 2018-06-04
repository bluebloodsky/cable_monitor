<template>
  <section>页面正在开发中。。。</section>
</template>
<script>
export default {

}

</script>
<style scoped>
section {
  margin-top: 150px;
  text-align: center;
  font-size: 50px;
  color: #78B0C1;
}

.find-div-body {
  position: relative;
  top: 30px;
  right: 0px;
  padding: 8px;
  background-color: #FFFFFF;
  border: #cccccc solid 1px;
  border-radius: 3px;
}

.find-div-body:before {
  box-sizing: content-box;
  width: 0px;
  height: 0px;
  position: absolute;
  top: -16px;
  ;
  right: 41px;
  padding: 0;
  border-bottom: 8px solid #FFFFFF;
  border-top: 8px solid transparent;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  display: block;
  content: '';
  z-index: 12;
}

.find-div-body:after {
  box-sizing: content-box;
  width: 0px;
  height: 0px;
  position: absolute;
  top: -18px;
  ;
  right: 40px;
  padding: 0;
  border-bottom: 9px solid #cccccc;
  border-top: 9px solid transparent;
  border-left: 9px solid transparent;
  border-right: 9px solid transparent;
  display: block;
  content: '';
  z-index: 10
}

</style>
