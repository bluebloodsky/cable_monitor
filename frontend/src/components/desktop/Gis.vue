<template>
  <section ref="container"></section>
</template>
<script>
export default {
  data() {
    return {
      map: null,
      startPoint: [114.447257, 30.496942],
      endPoint: [114.450266, 30.445063],
      gis: [
        [114.448091, 30.512703],
        [114.451315, 30.507733],
        [114.452547, 30.505904],
        [114.452908, 30.504585],
        [114.452744, 30.503073],
        [114.447606, 30.497379],
        [114.445198, 30.492337],
        [114.443274, 30.482495],
        [114.443546, 30.468964],
        [114.44448,30.460964],
        [114.44969,30.445616],
        [114.449331,30.441568]
      ],

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

    var points = []
    this.gis.map(point => {
      points.push(new BMap.Point(point[0], point[1]))
    })
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
