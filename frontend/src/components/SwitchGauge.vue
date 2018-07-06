<template>
  <canvas ref="container"></canvas>
</template>
<script>
import { RadialGauge } from "canvas-gauges";
export default {
  props: {
    param: Object
  },
  data() {
    return {
      gauge: null
    };
  },
  watch: {
    param(newVal) {
      this.gauge.value = newVal.val
    }
  },
  mounted() {
    let container = this.$refs["container"];
    this.gauge = new RadialGauge({
      renderTo: container,
      title: this.param.name_cn,
      colorTitle: "#eee",
      width: 300,
      height: 300,
      startAngle: 90,
      ticksAngle: 180,
      needleCircleOuter: true,
      needleCircleInner: false,

      minValue: 0,
      maxValue: 1,
      majorTicks: ["关", "开"],
      minorTicks: 2,
      strokeTicks: false,
      highlights: [{ from: 0, to: 0.5, color: "rgba(0,255,0,.15)" }, { from: 0.5, to: 1, color: "rgba(255,30,0,.25)" }],
      colorPlate: "#222",
      colorMajorTicks: "#f5f5f5",
      colorMinorTicks: "#ddd",
      colorTitle: "#fff",
      colorUnits: "#ccc",
      colorNumbers: "#eee",
      colorNeedle: "rgba(240, 128, 128, 1)",
      colorNeedleEnd: "rgba(255, 160, 122, .9)",
      valueBox: false,
      animationRule: "bounce",
      animationDuration: 500
    })
    this.gauge.draw()
  }
};

</script>
