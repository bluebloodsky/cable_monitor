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
        formatter: "{c}"
      },
      toolbox: {
        feature: {
          restore: {},
          saveAsImage: {}
        }
      },
      series: [{
        name: this.param.name_cn,
        type: 'gauge',
        detail: { formatter: '{value}' },
        data: [{ value: 50 }]
      }]
    }
    this.chart.setOption(this.option)
  }
}

</script>
<style scoped>
div {
  width: 200px;
  height: 200px;
}

section {
  text-align: center;
}

</style>
