<template>
  <canvas ref="container"></canvas>
</template>
<script>
import { LinearGauge } from "canvas-gauges";
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
    this.gauge = new LinearGauge({
      renderTo: container,
      width: 100,
      height: 300,
      borderRadius: 0,
      units: this.param.unit,
      title: this.param.name_cn,
      barBeginCircle: false,
      minValue: -30,
      maxValue: 90,
      majorTicks: [
        "-30",
        "0",
        "30",
        "60",
        "90"
      ],
      highlights: [
        { from: -30, to: 50, color: "rgba(0,255,0,.15)" },
        { from: 50, to: 90, color: "rgba(255,30,0,.25)" }
      ],
      tickSide: "right",
      numberSide: "right",
      needleSide: "right",
      colorPlate: "#eee",
      valueBoxBorderRadius: 0,
      barStrokeWIdth: 5,
      animationRule: "elastic",
      animationDuration: 500
    })
    this.gauge.draw()
  }
};

</script>
