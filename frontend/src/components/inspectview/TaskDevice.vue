<template>
  <section>
    <ul>
      <li>任务设备</li>
      <li>结果一览</li>
    </ul>
    <ul v-for="i in 10">
      <li>管廊雨污舱氧气传感器</li>
      <li></li>
    </ul>
  </section>
</template>
<script>
export default {

}

</script>
<style scoped>
ul {
  height: 45px;
  display: flex;
  justify-content: space-around;
  align-items: center;
  margin: 0 10px 10px 10px;
  background-color: #EAF1F7;
  color: #707070;
}

ul:not(:first-child):hover {
  background-color: #D0DEE9;
  cursor: pointer;
}

ul:first-child {
  background-color:  #B0C6DB;
  margin: 0 0 15px 0;
}

ul li {
  width: 30%;
}

ul li:last-child {
  width: 60%;
}

</style>
