<template>
  <section>
    <!-- <header>
      <span>告警统计</span>
    </header> -->
      <ul>
        <li>
          <span>告警信息</span>
          <span>严重</span>
          <span>危急</span>
        </li>
        <li>
          <span><strong>8</strong>条</span>
          <span><strong>1</strong>条</span>
          <span><strong>2</strong>条</span>
        </li>
      </ul>
  </section>
</template>
<script>
export default {
  data() {
    return {};
  }
};
</script>
<style scoped>
header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  padding-left: 15px;
  /*background-color: #1E364E;*/
  /*border: 1px solid #406985;*/
  margin-bottom: 10px;
}

header:before {
  content: "";
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 18px solid #406985;
  border-right: 18px solid transparent;
}

header:after {
  content: "";
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 16px solid #132d48;
  border-right: 16px solid transparent;
}

section > div {
  height: 100%;
  overflow-y: auto;
}

ul {
  margin-left: 50px;
  width: calc(100% - 100px);
  border-left: 1px solid #729fb6;
  border-right: 1px solid #729fb6;
}
li {
  height: 50px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

li span {
  width: 25%;
  font-size: 20px;
}
li:not(:first-child) span {
  color: #4c89a8;
}
strong {
  color: #c8e3ee;
  font-size: 30px;
  margin-right: 10px;
  font-weight: normal;
}
</style>
