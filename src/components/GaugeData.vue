<template>
  <section>
    <div ref="wrapper"></div>
    <span>{{param.name_cn}}({{param.unit}})</span>
  </section>
</template>
<script>
import echarts from 'echarts'
export default {
  props: {
    param: Object
  },
  data() {
    return {
      chart: null,
      option: {},
    }
  },
  mounted() {
    this.chart = echarts.init(this.$refs['wrapper'])
    this.option = {
      tooltip: {
        formatter: "{a} <br/>{b} : {c}%"
      },
      toolbox: {
        feature: {
          restore: {},
          saveAsImage: {}
        }
      },
      series: [{
        name: '业务指标',
        type: 'gauge',
        detail: { formatter: '{value}%' },
        data: [{ value: 50, name: '完成率' }]
      }]
    }
    this.chart.setOption(this.option)
  }
}

</script>
<style scoped>
div {
  width: 100%;
  height: 200px;
}

</style>
