<template>
  <section>
    <header>
      <span>任务概况</span>
    </header>
    <div>
      <table>
        <thead>
          <tr>
            <th v-for="field in fields">{{field.caption}}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="i in 6">
            <td><a>线路定位</a></td>
            <td><a>巡视轨迹</a></td>
            <td>500kV下凤1回</td>
            <td>正常巡视</td>
            <td>0/34</td>
          </tr>
        </tbody>
      </table>
    </div>
    <footer>
      <div>
        <button type="text">
          <i class="iconfont icon-angle-double-left"></i>
        </button>
        <button type="text">
          <i class="iconfont icon-return"></i>
        </button>
        <input value="1">
        <button type="text">
          <i class="iconfont icon-enter"></i>
        </button>
        <button type="text">
          <i class="iconfont icon-angle-double-right"></i>
        </button>
        <span> 共1页 6条</span>
      </div>
      <div>已执行:0 执行中:6</div>
    </footer>
  </section>
</template>
<script>
export default {
  data() {
    return {
      fields: [
        { name: "positon", caption: '线路定位' },
        { name: 'path', caption: '巡视轨迹' },
        { name: 'wire_name', caption: '线路名称' },
        { name: 'inspect_type', caption: '巡视类型' },
        { name: 'inspect_state', caption: '巡视情况' },
      ]
    }
  }
}

</script>
<style scoped>
header {
  position: relative;
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  padding-left: 15px;
  background-color: #1E364E;
  border-bottom: 1px solid #406985;
  margin-bottom: 3px;
}

header:before {
  content: '';
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 18px solid #406985;
  border-right: 18px solid transparent;
}

header:after {
  content: '';
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 16px solid #132D48;
  border-right: 16px solid transparent;
}

section>div {
  height: calc(100% - 60px);
  overflow-y: auto;
}

footer {
  position: absolute;
  bottom: 0;
  left: 0;
  top: auto;
  right: 0;
  height: 30px;
  line-height: 30px;
  background-color: #133551;
  border-radius: 5px 0;
  padding-left: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

td,
th,
table {
  border: 1px solid #2B4F69;
  font-weight: normal;
}

thead {
  background-color: #06192A;
  line-height: 28px;
}

tbody {
  line-height: 26px;
  text-align: center;
}

a {
  color: #DFF789;
  text-decoration: underline;
}


footer div {
  margin-right: 50px;
  float: left;
}

input {
  width: 16px;
  text-align: center;
}

.iconfont {
  color: #fff;
}

</style>
