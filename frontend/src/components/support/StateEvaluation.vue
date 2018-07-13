<template>
  <section>
    <div class="box">
      <header>
        <span>设备资料</span>
      </header>
      <section>
        <table>
          <tr>
            <td class="desc">安装地点</td>
            <td>{{deviceState.baseInfo.location}}</td>
            <td class="desc">运行编号</td>
            <td>{{deviceState.baseInfo.code}}</td>
            <td class="desc">型号</td>
            <td>{{deviceState.baseInfo.type}}</td>
          </tr>
          <tr>
            <td class="desc">电缆本体生产厂家</td>
            <td></td>
            <td class="desc" rowspan="3">生产日期</td>
            <td></td>
            <td class="desc" rowspan="3">投运日期</td>
            <td></td>
          </tr>
          <tr>
            <td class="desc">中间接头生产厂家</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="desc">电缆终端生产厂家</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="desc">额定电压</td>
            <td></td>
            <td class="desc">额定电流</td>
            <td></td>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td class="desc">上次评价结果/时间</td>
            <td colspan="5"></td>
          </tr>
        </table>
      </section>
    </div>
    <div class="box">
      <header>
        <span>评价结果</span>
      </header>
      <section>
        <div class="this-eval">
          <span>本次评价:</span>
          <textarea readonly>状态良好</textarea>
        </div>
        <table>
          <tr>
            <td class="desc">评价指标</td>
            <td class="desc">电缆本体</td>
            <td class="desc">电缆终端</td>
            <td class="desc">辅助设施</td>
            <td class="desc">中间接头</td>
            <td class="desc">电缆线路过电压</td>
            <td class="desc">通道</td>
          </tr>
          <tr>
            <td class="desc">状态定级</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="desc">扣分值</td>
            <td colspan="7"></td>
          </tr>
        </table>
        <div class="all-eval">
          <span>整体评价结果（诊断后）</span>
          <section>
            <input type="radio" checked name="all-eval"> 正常状态
            <input type="radio" name="all-eval"> 注意状态
            <input type="radio" name="all-eval"> 异常状态
            <input type="radio" name="all-eval"> 严重状态
          </section>
        </div>
        <table>
          <tr>
            <td class="desc">扣分量状态描述</td>
            <td>
              主要扣分情况：
              <input readonly>
              <br> 描述重要状态量扣分项情况，如一般状态量评价为最差状态时，也应描述;
            </td>
          </tr>
          <tr>
            <td class="desc">处理建议</td>
            <td></td>
          </tr>
          <tr>
            <td class="desc">评价时间</td>
            <td></td>
          </tr>
          <tr>
            <td>评价人：
              <input readonly> </td>
            <td>审核：
              <input readonly>
            </td>
          </tr>
          <tr>
            <td class="desc" colspan="2">上述诊断结果、扣分状态量描述如报告篇幅不够，可用附录说明</td>
          </tr>
        </table>
      </section>
    </div>
  </section>
</template>
<script>
export default {
  props: {},
  data() {
    return {
      deviceState: {
        baseInfo: {
          location: '500kV下凤1回',
          code: '20130701001',
          type: 'DL002'
        }
      }
    }
  }
}

</script>
<style scoped>
.box {
  margin: 0 10px;
  border: 1px solid #9c9c9c;
  border-top: none;
  color: #3c3c3c;
}

.box:first-child {
  border-top: 1px solid #9c9c9c;
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

.this-eval {
  height: 120px;
  width: 100%;
  margin-bottom: 5px;
  line-height: 30px;
}

.this-eval span {
  padding-left: 10px;
  font-size: 14px;
}

.this-eval textarea {
  height: calc(100% - 50px);
  width: calc(100% - 22px);
  padding: 10px;
}

.all-eval {
  font-size: 14px;
  line-height: 30px;
  padding-left: 10px
}

</style>
