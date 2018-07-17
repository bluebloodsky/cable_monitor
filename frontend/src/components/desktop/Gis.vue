<template>
  <section ref="container"></section>
</template>
<script>
export default {
  data() {
    return {
      map: null,
      gis: [
        [114.378229,30.378952],
        [114.378283,30.382862],
        [114.374187,30.382441],
        [114.367593,30.379591],
        [114.365886,30.378983],
        [114.364018,30.377706],
        [114.362473,30.377114],
        [114.346016,30.374154],
        [114.344441,30.373951]
      ],

    };
  },
  mounted() {
    this.map = new BMap.Map(this.$refs["container"], {
      mapType: BMAP_HYBRID_MAP
    });

    // 创建点坐标
    this.map.centerAndZoom(new BMap.Point(114.40,30.38), 13);
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
     polyline.addEventListener("click", e => {
        this.$router.push('data')
      })
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
