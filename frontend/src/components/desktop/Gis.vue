<template>
  <section ref="container"></section>
</template>
<script>
export default {
  data() {
    return {
      map: null,
      startPoint: [114.447257, 30.496942],
      endPoint: [114.450266, 30.445063]
    };
  },
  mounted() {
    this.map = new BMap.Map(this.$refs["container"], {
      mapType: BMAP_HYBRID_MAP
    });

    // 创建点坐标
    this.map.centerAndZoom(new BMap.Point(114.49639, 30.474205), 13);
    this.map.setMapStyle({ style: "light" });
    this.map.enableScrollWheelZoom(true);

    // var sy = new BMap.Symbol(BMap_Symbol_SHAPE_BACKWARD_OPEN_ARROW, {
    //   scale: 0.6, //图标缩放大小
    //   strokeColor: '#fff', //设置矢量图标的线填充颜色
    //   strokeWeight: '2', //设置线宽
    // });

    var points = [new BMap.Point(this.startPoint[0],this.startPoint[1]),new BMap.Point(this.endPoint[0],this.endPoint[1])];
    var polyline = new BMap.Polyline(points, {
      strokeColor: "red",
      strokeWeight: 8,
      strokeOpacity: 0.8
    });
    this.map.addOverlay(polyline)
  }
};
</script>
<style scoped>
section {
  width: 100%;
  height: 100%;
}
</style>
