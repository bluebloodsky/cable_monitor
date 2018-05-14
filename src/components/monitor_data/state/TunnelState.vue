<template>
  <section>
    <div v-for="item in node.children" class="content-box">
      <div>
        <i class="iconfont" :class="item.icon" v-if="item.icon"></i>
        <span>{{item.label}}</span>
      </div>
      <ul>
        <li><i class="iconfont icon-circle good"></i>通讯状态</li>
        <li><i class="iconfont icon-circle good"></i>运行状态</li>
      </ul>
    </div>
  </section>
</template>
<script>
export default {
  props: {
    node: Object
  }
}

</script>
<style scoped>
section {
  padding-left: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;
}

.content-box {
  position: relative;
  font-size: 16px;
  background-color: #38648D;
  margin-bottom: 5px;
  margin-right: 5px;
  width: 280px;
  height: 80px;
  padding-bottom: 10px;
  border-radius: 5px;
  display: flex;
  justify-content: space-around;
}

.content-box>div {
  width: 160px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.content-box>div i {
  font-size: 60px;
}

.content-box>ul {
  width: 100px;
  padding: 10px 0;
}

.content-box li {
  height: 30px;
  line-height: 30px;
}

</style>
