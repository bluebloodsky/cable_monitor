<template>
  <section>
    <header>
      <span>缺陷记录</span>
    </header>
    <div>
      <table>
        <thead>
          <tr>
            <th v-for="field in fields">{{field.caption}}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="i in 4">
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
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
    </footer>
  </section>
</template>
<script>
export default {
  data() {
    return {
      fields: [
        { name: "wire_name", caption: '缺陷所属线路' },
        { name: 'fault_handle', caption: '发现缺陷计划' },
        { name: 'fault_level', caption: '缺陷级别' },
        { name: 'fault_time', caption: '发现缺陷时间' },
      ]
    }
  }
}

</script>
<style scoped>
header {
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


span {
  margin-right: 50px;
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
