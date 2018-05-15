<template>
  <section>
    <canvas ref="container"></canvas>
    <p>{{param.name_cn}}</p>
  </section>
</template>
<script>
import { LinearGauge, RadialGauge } from "canvas-gauges";
import echarts from "echarts";
export default {
  props: {
    param: Object
  },
  data() {
    return {
      gauge: null
    };
  },
  mounted() {
    let container = this.$refs["container"];
    if (this.param.show_type == "Linear") {
      this.gauge = new LinearGauge({
        renderTo: container,
        width: 100,
        height: 300,
        borderRadius:0,
        units:this.param.unit,
        barBeginCircle:false,
        minValue: -30,
        maxValue: 90,
        majorTicks:[
          "-30",
          "0",
          "30",
          "60",
          "90"
        ],
        highlights: [
          { from:-30 , to: 50, color: "rgba(0,255,0,.15)" },
          { from: 50, to: 90, color: "rgba(255,30,0,.25)" }
        ],
        tickSide:"right",
        numberSide:"right",
        needleSide:"right",
        colorPlate:"#eee",
        valueBoxBorderRadius:0,
        barStrokeWIdth:5,
        animationRule: "elastic",
        animationDuration: 500
      });
    } else {
      this.gauge = new RadialGauge({
        renderTo: container,
        width: 200,
        height: 200,
        units: "pC",
        title: false,
        value: 12,
        minValue: 0,
        maxValue: 220,
        majorTicks: [
          "0",
          "20",
          "40",
          "60",
          "80",
          "100",
          "120",
          "140",
          "160",
          "180",
          "200",
          "220"
        ],
        minorTicks: 2,
        strokeTicks: false,
        highlights: [
          { from: 0, to: 100, color: "rgba(0,255,0,.15)" },
          { from: 100, to: 200, color: "rgba(255,30,0,.25)" },
          { from: 200, to: 220, color: "rgba(0,0,255,.25)" }
        ],
        colorPlate: "#222",
        colorMajorTicks: "#f5f5f5",
        colorMinorTicks: "#ddd",
        colorTitle: "#fff",
        colorUnits: "#ccc",
        colorNumbers: "#eee",
        colorNeedle: "rgba(240, 128, 128, 1)",
        colorNeedleEnd: "rgba(255, 160, 122, .9)",
        valueBox: true,
        animationRule: "bounce",
        animationDuration: 500
      });
    }
    this.gauge.draw();
    this.gauge.value = 50;
  }
};
</script>
<style scoped>
section{
  text-align: center;
}
</style>
