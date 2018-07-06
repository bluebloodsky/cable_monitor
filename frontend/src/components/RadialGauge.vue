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
      this.gauge.value = newVal.val;
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
      units: this.param.unit,
      value: this.param.val ? this.param.val : 12,
      minValue: 0,
      maxValue: 100,
      majorTicks: ["0", "20", "40", "60", "80", "100"],
      minorTicks: 2,
      strokeTicks: false,
      highlights: [{ from: 0, to: 70, color: "#28A646" }, { from: 70, to: 85, color: "#FEE179" }, { from: 85, to: 100, color: "#C55C60" }],
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
    })
    this.gauge.draw()
  }
};

</script>
