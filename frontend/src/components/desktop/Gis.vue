<template>
  <section ref="container"></section>
</template>
<script>
export default {
  props: ['baseInfos', 'moveFlg'],
  data() {
    return {
      map: null,
      circle: null,
      startPoint: [114.447257, 30.496942],
      endPoint: [114.450266, 30.445063],
      locatePercent: 0, //0~1表示起点到终点
      step: 0.001,
    }
  },
  methods: {
    inLine(p, s, e) {
      let k = (e[1] - s[1]) / (e[0] - s[0])
      let x = (k * s[0] - s[1] + p[0] / k + p[1]) / (k + 1 / k)
      let y = k * (x - s[0]) + s[1]

      if ((e[0] - x) * (s[0] - x) < 0 &&
        ((x - p[0]) * (x - p[0]) + (y - p[1]) * (y - p[1]) < 0.000004)) {
        return [x, y]
      } else {
        return []
      }
    }
  },
  watch: {
    locatePercent(newVal) {
      this.$emit('locate-change', newVal)
      var p = new BMap.Point(this.startPoint[0] + (this.endPoint[0] - this.startPoint[0]) * newVal,
        this.startPoint[1] + (this.endPoint[1] - this.startPoint[1]) * newVal)
      this.circle.setCenter(p)
    }
  },
  mounted() {
    this.map = new BMap.Map(this.$refs['container'], {
      mapType: BMAP_HYBRID_MAP
    })

    // 创建点坐标  
    this.map.centerAndZoom(new BMap.Point(114.49639, 30.474205), 13)
    this.map.setMapStyle({ style: "light" })
    this.map.enableScrollWheelZoom(true)

    // var sy = new BMap.Symbol(BMap_Symbol_SHAPE_BACKWARD_OPEN_ARROW, {
    //   scale: 0.6, //图标缩放大小
    //   strokeColor: '#fff', //设置矢量图标的线填充颜色
    //   strokeWeight: '2', //设置线宽
    // });

    this.baseInfos && this.baseInfos.map(baseInfo => {
      var points = []
      baseInfo.gis.map(point => {
        points.push(new BMap.Point(point[0], point[1]))
      })
      // var icons = new BMap.IconSequence(sy, '100%', '30');
      // var polyline = new BMap.Polyline(points, { strokeColor: "#10FD0F", strokeWeight: 5, icons: [icons], strokeOpacity: 0.8 })
      var polyline = new BMap.Polyline(points, { strokeColor: "#10FD0F", strokeWeight: 8, strokeOpacity: 0.8 })
      polyline.addEventListener("click", e => {
        var sp = this.inLine([e.point.lng, e.point.lat], this.startPoint, this.endPoint)
        if (sp.length) {
          this.locatePercent =
            (sp[1] - this.startPoint[1]) / (this.endPoint[1] - this.startPoint[1])
        }
      })
      this.map.addOverlay(polyline);
    })

    var diffPoint = [this.endPoint[0] - this.startPoint[0], this.endPoint[1] - this.startPoint[1]]

    this.circle = new BMap.Circle(new BMap.Point(this.startPoint[0], this.startPoint[1]), 150, { strokeColor: 'red', fillColor: "red", strokeWeight: 2, fillOpacity: 1 });
    this.map.addOverlay(this.circle);
    window.setInterval(() => {
      if (this.moveFlg) {
        if (this.locatePercent > 1) {
          this.locatePercent = 0
        } else {
          this.locatePercent += this.step
        }
      }
    }, 100)
  }
}

</script>
<style scoped>
section{
  width: 100%;
  height: 100%;
}
</style>
