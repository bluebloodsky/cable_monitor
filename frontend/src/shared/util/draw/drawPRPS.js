import {
  CanvasDraw
} from './tool'

function initMixin(DrawPRPS) {
  DrawPRPS.prototype = {
    _init: function (container) {
      let canvas = document.createElement('canvas')
      canvas.width = container.clientWidth
      canvas.height = container.clientHeight
      container.appendChild(canvas)
      this._container = container
      this._canvas = canvas
      this._width = canvas.width
      this._height = canvas.height
      this._period = 0
      this.$options = {
        title: 'PRPS图',
        xDesc: '相位',
        zDesc: '幅值',
        phaseX: 0 ,
        phaseY: Math.PI  / 4,
        // phaseX: - Math.PI  / 6,
        // phaseY: Math.PI  * 5 / 6,
        colors: ['lightgrey', 'lightgrey', 'blue', '#3c3c3c', 'red', 'blue'],
        step: 1,
      }
    },
    items: [],
    axes: [],
    get _coordinate() {
      return {
        // originX: 50 ,
        // originY: this._height * 0.6,
        originX: this._width * 0.5,
        originY: this._height * 0.35,
        maxX: this._width / 2 - 10,
        maxY: this._width / 2 ,
        maxZ: this._height * 0.35 - 35
      }
    },
    /*将 NQφ 映射到坐标系中*/
    _coordinateMap: function (x, y, z) {
      let tmpX = Math.cos(this.$options.phaseX) * x - Math.cos(this.$options.phaseY) * y;
      let tmpY = Math.sin(this.$options.phaseX) * x + Math.sin(this.$options.phaseY) * y - z;
      return [tmpX + this._coordinate.originX, tmpY + this._coordinate.originY];
    },
    _initAxis: function () {
      let maxX = this._coordinate.maxX
      let maxY = this._coordinate.maxY
      let maxZ = this._coordinate.maxZ
      this.axes = [];
      this.$options.title &&
        this.axes.push({
          type: 'text',
          x: this._width / 2 -10 ,
          y: 20,
          text: this.$options.title,
          font: '14px Arial',
          fill: this.$options.colors[3]
        })
      this.$options.xDesc &&
        this.axes.push({
          type: 'text',
          x: this._coordinateMap(maxX, maxY, 0)[0] + 20,
          y: this._coordinateMap(maxX, maxY, 0)[1] + 5,
          text: this.$options.xDesc,
          fill: this.$options.colors[3]
        })

      this.$options.zDesc &&
        this.axes.push({
          type: 'text',
          x: this._coordinateMap(0, maxY, maxZ)[0],
          y: this._coordinateMap(0, maxY, maxZ)[1] - 10,
          text: this.$options.zDesc,
          rotate: 270,
          fill: this.$options.colors[3]
        })
      for (var i = 0; i < 5; i++) {
        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(maxX * i / 4, 0, 0), this._coordinateMap(maxX * i / 4, 0, maxZ)], //XZ面Z轴
          fill: this.$options.colors[0]
        });
        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(0, 0, maxZ * i / 4), this._coordinateMap(maxX, 0, maxZ * i / 4)], //XZ面X轴
          fill: this.$options.colors[0]
        });

        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(maxX * i / 4, 0, 0), this._coordinateMap(maxX * i / 4, maxY, 0)], //XY面Y轴
          fill: this.$options.colors[0]
        });

        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(0, 0, maxZ * i / 4), this._coordinateMap(0, maxY, maxZ * i / 4)], //YZ面Y轴
          fill: this.$options.colors[0]
        });
        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(0, maxY * i / 4, 0), this._coordinateMap(0, maxY * i / 4, maxZ)], //YZ面Z轴
          fill: this.$options.colors[0]
        });
      }
      for (var i = 0; i < 51; i++) {
        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(0, maxY * i / 50, 0), this._coordinateMap(maxX, maxY * i / 50, 0)], //XY面X轴
          fill: this.$options.colors[1]
        });
      }
    },
    _getLine: function (period) {
      var maxX = this._coordinate.maxX
      var maxY = this._coordinate.maxY
      var maxZ = this._coordinate.maxZ
      let points = this.$options.points
      let step = this.$options.step

      this.items = []

      var maxXValue = points[0][0][0]; //x
      var maxYValue = points[0][0][1]//y
      var maxZValue = points[0][0][2]; //z
      var minZValue = points[0][0][2]; //-z
      for (var i = 0; i < points.length; i++) {
        for (var j = 0; j < points[i].length; j++) {
          if (maxXValue < parseFloat(points[i][j][0])) {
            maxXValue = parseFloat(points[i][j][0])
          }
          if (maxYValue < parseFloat(points[i][j][1])) {
            maxYValue = parseFloat(points[i][j][1])
          }
          if (maxZValue < parseFloat(points[i][j][2])) {
            maxZValue = parseFloat(points[i][j][2])
          }
          if (minZValue > parseFloat(points[i][j][2])) {
            minZValue = parseFloat(points[i][j][2])
          }
        }
      }
      this.items.push({
        type: 'text',
        x: this._coordinateMap(-maxX, 0, maxZ - 10)[0],
        y: this._coordinateMap(-maxX, 0, maxZ - 10)[1],
        text: '最大值：' + maxZValue.toFixed(2),
        fill: this.$options.colors[4]
      }, {
        type: 'text',
        x: this._coordinateMap(-maxX, 0, maxZ - 30)[0],
        y: this._coordinateMap(-maxX, 0, maxZ - 30)[1],
        text: '最小值：' + minZValue.toFixed(2),
        fill: this.$options.colors[5]
      })
      minZValue = Math.floor(minZValue ) 
      var ZRange = Math.round((maxZValue - minZValue) * 1.2 / 10) * 10;
      if (ZRange == 0) {
        ZRange = 10
      }
      //画坐标轴量程
      for (var i = 0; i < 5; i++) {
        this.items.push({
          type: 'text',
          x: this._coordinateMap(0, maxY, maxZ * i / 4)[0] - 45,
          y: this._coordinateMap(0, maxY, maxZ * i / 4)[1],
          text: (ZRange * i / 4 + minZValue).toFixed(2),
          fill: this.$options.colors[3]
        }, {
          type: 'text',
          x: this._coordinateMap(maxX * i / 4, maxY, 0)[0] - 10,
          y: this._coordinateMap(maxX * i / 4, maxY, 0)[1] + 15,
          text: maxXValue * i / 4,
          fill: this.$options.colors[3]
        })
      }
      //将数据转化为三维图上的点,并将前后两个点依次相连成线
      for (var i = 0; i < period; i++) {
        var points_2d = [];
        var point0 = this._coordinateMap(points[i][0][0] * maxX / maxXValue,
          (period - points[i][0][1] + 1) * maxY / maxYValue, (points[i][0][2] - minZValue) * maxZ / ZRange);
        points_2d.push(point0);
        for (var j = step; j < points[i].length; j += step) {
          var zValue = points[i][j][2];
          //  当step ！=1时，取step范围内峰值，避免错过波峰波谷
          for (var k = 1; k < step; k++) {
            if (Math.abs(zValue) < Math.abs(points[i][j - k][2])) {
              zValue = points[i][j - k][2];
            }
          }
          var point = this._coordinateMap(points[i][j][0] * maxX / maxXValue,
            (period - points[i][j][1] + 1) * maxY / maxYValue, (zValue - minZValue) * maxZ / ZRange);
          points_2d.push(point);
        }
        this.items.push({
          type: 'line',
          path: points_2d,
          fill: this.$options.colors[2]
        });
      }
    },
    setOption: function (options) {
      for (const key in options) {
        this.$options[key] = options[key]
      }
      this._initAxis()
    },
    resize: function () {
      this._canvas.width = this._container.clientWidth
      this._canvas.height = this._container.clientHeight
      this._width = this._canvas.width
      this._height = this._canvas.height
      this._initAxis()
      this.draw(this._period)
    },

    draw: function (period) {
      this._period = period
      let ctx = this._canvas.getContext("2d")
      ctx.clearRect(0, 0, this._width, this._height);
      CanvasDraw(ctx, this.axes);
      this._getLine(period);
      CanvasDraw(ctx, this.items);
    }
  }
}

function DrawPRPS(container) {
  if (!(this instanceof DrawPRPS)) {
    throw 'DrawPRPS is a constructor and should be called with the `new` keyword'
  }
  this._init(container)
}
initMixin(DrawPRPS)

export default DrawPRPS
