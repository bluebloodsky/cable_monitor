<template>
  <section>
    <div class="select-box">
      <span>时间轴</span>
      <section>
        <div v-for="(t,index) in tests" class="icon-box">
          <button type="text" :title="t.time" @click="select_index = index">
            <i class="iconfont icon-circle" :class="[t.type , select_index == index ?'active' : '']"></i>
          </button>
          <br>
          <span>{{t.time}}</span>
        </div>
      </section>
      <p>说明：
        <span><i class="iconfont icon-circle a"></i>A类检修</span>
        <span><i class="iconfont icon-circle b"></i>B类检修</span>
        <span><i class="iconfont icon-circle c"></i>C类检修</span>
        <span><i class="iconfont icon-circle d"></i>D类检修</span>
      </p>
    </div>
    <div class="box">
      <header>
        <span>局部放电</span>
      </header>
      <section>
        <table>
          <tr>
            <td class="desc">试验单位</td>
            <td colspan="5">国网电力科学研究院武汉南瑞有限责任公司</td>
          </tr>
          <tr>
            <td class="desc">试验负责人</td>
            <td>沈盼</td>
            <td class="desc">试验人员</td>
            <td>胡长猛、蔡守军</td>
            <td class="desc">报告日期</td>
            <td>{{tests[select_index].time}}</td>
          </tr>
          <tr>
            <td class="desc">线路名称</td>
            <td>500kV下凤一回</td>
            <td class="desc">电压等级</td>
            <td>500kV</td>
            <td class="desc">测试仪器</td>
            <td>PD Check</td>
          </tr>
          <tr>
            <td class="desc">异常信号位置</td>
            <td colspan="5">无</td>
          </tr>
          <tr>
            <td class="desc">背景信号</td>
            <td colspan="5">0.0002V</td>
          </tr>
          <tr>
            <td class="desc" rowspan="2">局放信息</td>
            <td class="desc">检测时间</td>
            <td class="desc" colspan="4">高频局放信号（pC）</td>
          </tr>
          <tr>
            <td>{{tests[select_index].time}}</td>
            <td colspan="4">0.2V</td>
          </tr>
        </table>
        <div class="wave">
          <span>图谱分析</span>
          <section>
            <div v-for="i in 4">
              <img src="/static/img/1.jpg" :key="i">
              <br>
              <span>中心频率M Hz-A相相位谱图-{{tests[select_index].time}}</span>
            </div>
          </section>
        </div>
        <table>
          <tr>
            <td colspan="2" class="desc">诊断分析和缺陷性质</td>
          </tr>
          <tr>
            <td colspan="2">检测结果分析： A相接收到了符合电晕特征的高频信号，B相接收到的高频信号对应的PRPD图显示出信号分布在第二、四象限的下降沿，不符合典型局部放电特征，说明B相接收到的高频信号可能来源于外界干扰，C相接收到了符合电晕放电特征的高频信号。
              <br> 建议： 进行周期性检测，关注A、C相电晕放电幅值的变化</td>
          </tr>
          <tr>
            <td colspan="2" class="desc">处理意见</td>
          </tr>
          <tr>
            <td colspan="2">进行周期性检测</td>
          </tr>
          <tr>
            <td colspan="2" class="desc">审批意见</td>
          </tr>
          <tr>
            <td>检测人员： 沈盼、胡长猛、蔡守军</td>
            <td>审核： </td>
          </tr>
        </table>
      </section>
    </div>
    <div class="box">
      <header>
        <span>红外图谱</span>
      </header>
      <section>
        <table>
          <tr>
            <td class="desc">试验单位</td>
            <td colspan="5">国网电力科学研究院武汉南瑞有限责任公司</td>
          </tr>
          <tr>
            <td class="desc">试验负责人</td>
            <td>沈盼</td>
            <td class="desc">试验人员</td>
            <td>胡长猛、蔡守军</td>
            <td class="desc">报告日期</td>
            <td>{{tests[select_index].time}}</td>
          </tr>
          <tr>
            <td class="desc">线路名称</td>
            <td>500kV下凤一回</td>
            <td class="desc">电压等级</td>
            <td>500kV</td>
            <td class="desc">测试仪器</td>
            <td>Flir红外热成像仪</td>
          </tr>
          <tr>
            <td class="desc">异常信号位置</td>
            <td colspan="5">无</td>
          </tr>
        </table>
        <div class="wave">
          <span>图谱分析</span>
          <section>
            <div v-for="i in 4">
              <img src="/static/img/IR1.jpg" :key="i">
              <br>
              <span>A相红外图谱-{{tests[select_index].time}}</span>
            </div>
          </section>
        </div>
        <table>
          <tr>
            <td colspan="2" class="desc">诊断分析和缺陷性质</td>
          </tr>
          <tr>
            <td colspan="2">无异常</td>
          </tr>
          <tr>
            <td colspan="2" class="desc">处理意见</td>
          </tr>
          <tr>
            <td colspan="2">进行周期性检测</td>
          </tr>
          <tr>
            <td colspan="2" class="desc">审批意见</td>
          </tr>
          <tr>
            <td>检测人员： 沈盼、胡长猛、蔡守军</td>
            <td>审核： </td>
          </tr>
        </table>
      </section>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      tests: [{
        time: '2018-01-13',
        type: 'd'
      }, {
        time: '2018-02-15',
        type: 'd'
      }, {
        time: '2018-03-13',
        type: 'b'
      }, {
        time: '2018-03-27',
        type: 'd'
      }, {
        time: '2018-04-13',
        type: 'c'
      }, {
        time: '2018-05-12',
        type: 'd'
      }, {
        time: '2018-05-26',
        type: 'd'
      }, {
        time: '2018-06-10',
        type: 'd'
      }, {
        time: '2018-06-23',
        type: 'd'
      }],
      select_index: 0
    }
  }
}

</script>
<style scoped>
.select-box {
  padding-left: 15px;
  color: #3c3c3c;
  font-size: 14px;
  line-height: 40px;
  height: 80px;
  position: relative;
  margin-bottom: 15px;
}

.select-box>section {
  background-color: #3c3c3c;
  height: 2px;
  position: absolute;
  left: 100px;
  top: 20px;
  right: 20px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.icon-box{
  position: relative;
}
.icon-box span{
  position: absolute;
  top: 30px;
  left: -30px;
  width: 200px;
  line-height: 16px;
}
.box {
  margin: 0 10px;
  border: 1px solid #9c9c9c;
  /*border-top: none;*/
  color: #3c3c3c;
}

.box>header {
  height: 35px;
  text-align: left;
  line-height: 35px;
  font-size: 16px;
  padding-left: 10px;
  border-bottom: 1px solid #9c9c9c;
  background-color: #dfecec;
  color: #306C95;
}

.box>section {
  padding: 0;
}

table {
  width: 100%;
  border: none;
  border: 1px solid #9c9c9c;
  border-collapse: collapse;
  text-align: center;
  margin: 0;
  overflow: auto;
  line-height: 30px;
  font-size: 14px;
}

td,
th {
  border: 1px solid #9c9c9c;
  text-align: left;
  padding-left: 10px;
}

td.desc {
  background-color: #ddd;
  /*text-align: center;*/
}

.wave {
  width: 100%;
  margin-bottom: 5px;
  line-height: 30px;
}

.wave>span {
  padding-left: 10px;
  font-size: 14px;
}

.wave>section {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
}

.wave>section>div {
  width: 22%;
  text-align: center;
  font-size: 14px;
}

.wave img {
  width: 100%;
}

.a {
  color: red;
}

.b {
  color: orange;
}

.c {
  color: yellow;
}

.d {
  color: green;
}

.active {
  animation: blink 1000ms infinite;
}


@keyframes blink {
  from {
    opacity: 1.0;
  }
  50% {
    opacity: 0.2;
  }
  to {
    opacity: 1.0;
  }
}

p {
  padding-left: 80px;
  padding-top: 5px;
}

p span {
  display: inline-block;
  margin-right: 20px;
}

</style>
