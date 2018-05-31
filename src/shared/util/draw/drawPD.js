import {
  CanvasDraw
} from './tool'

function initMixin(DrawPD) {
  DrawPD.prototype._init = function (options) {
    this.$options = {
      canvas: options['canvas'],
      points: options['points'],
      title: options['title'] ? options['title'] : '局放图谱',
      xDesc: options['xDesc'] ? options['xDesc'] : '相位',
      zDesc: options['zDesc'] ? options['zDesc'] : '幅值',
      width: options['canvas'].width,
      height: options['canvas'].height,
      phaseX: 0,
      phaseY: Math.PI / 4,
      colors: ['grey', 'blue', 'red', '#808A87', '#228B22', '#FF8000', '#7FFFD4', 'red'],
      step: 1,
    }
  }
  DrawPD.prototype.items = []
  DrawPD.prototype.axes = []
  DrawPD.prototype.originX = function () {
    return this.$options.width * 0.5
  }
  DrawPD.prototype.originY = function () {
    return this.$options.height * 0.35
  }
  /*将 NQφ 映射到坐标系中*/
  DrawPD.prototype._coordinateMap = function (x, y, z) {
    let tmpX = Math.cos(this.$options.phaseX) * x - Math.cos(this.$options.phaseY) * y;
    let tmpY = Math.sin(this.$options.phaseX) * x + Math.sin(this.$options.phaseY) * y - z;
    return [tmpX + this.originX(), tmpY + this.originY()];
  }
  DrawPD.prototype._initAxis = function () {
    var maxX = this.$options.width / 2;
    var maxZ = this.$options.height / 5;
    this.axes = [];
    this.$options.title &&
      this.axes.push({
        type: 'text',
        x: this.$options.width / 2,
        y: 20,
        text: this.$options.title,
        font: '14px Arial'
      })
    this.$options.xDesc &&
      this.axes.push({
        type: 'text',
        x: this._coordinateMap(maxX, maxX, 0)[0],
        y: this._coordinateMap(maxX, maxX, 0)[1] + 30,
        text: this.$options.xDesc
      })

    this.$options.zDesc &&
      this.axes.push({
        type: 'text',
        x: this._coordinateMap(0, maxX, maxZ)[0] - 55,
        y: this._coordinateMap(0, maxX, maxZ)[1],
        text: this.$options.zDesc,
        rotate: 270
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
        path: [this._coordinateMap(maxX * i / 4, 0, 0), this._coordinateMap(maxX * i / 4, maxX, 0)], //XY面Y轴
        fill: this.$options.colors[0]
      });

      this.axes.push({
        type: 'line',
        path: [this._coordinateMap(0, 0, maxZ * i / 4), this._coordinateMap(0, maxX, maxZ * i / 4)], //YZ面Y轴
        fill: this.$options.colors[0]
      });
      this.axes.push({
        type: 'line',
        path: [this._coordinateMap(0, maxX * i / 4, 0), this._coordinateMap(0, maxX * i / 4, maxZ)], //YZ面Z轴
        fill: this.$options.colors[0]
      });
    }
    for (var i = 0; i < 51 ; i++) {
      this.axes.push({
        type: 'line',
        path: [this._coordinateMap(0, maxX * i / 50, 0), this._coordinateMap(maxX, maxX * i / 50 , 0)], //XY面X轴
        fill: this.$options.colors[1]
      });
    }
  }
  DrawPD.prototype._getLine = function (period) {
    var maxX = this.$options.width / 2;
    var maxZ = this.$options.height / 5;
    var maxXValue = 0; //x
    var maxYValue = 0; //y
    var maxZValue = 0; //z
    var minZValue = 0; //-z
    let points = this.$options.points
    let step = this.$options.step

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
    maxZValue = Math.floor(maxZValue)
    minZValue = Math.floor(minZValue)
    var ZRange = (maxZValue - minZValue) * 1.5;
    if (ZRange == 0) {
      ZRange = 1
    }

    this.items = []
    //画坐标轴量程
    for (var i = 0; i < 5; i++) {
      this.items.push({
        type: 'text',
        x: this._coordinateMap(0, maxX, maxZ * i / 4)[0] - 45,
        y: this._coordinateMap(0, maxX, maxZ * i / 4)[1],
        text: (ZRange * i / 4 + minZValue).toFixed(2)
      }, {
        type: 'text',
        x: this._coordinateMap(maxX * i / 4, maxX, 0)[0] - 10,
        y: this._coordinateMap(maxX * i / 4, maxX, 0)[1] + 15,
        text: maxXValue * i / 4
      })
    }
    //将数据转化为三维图上的点,并将前后两个点依次相连成线
    for (var i = 0; i < period; i++) {
      var points_2d = [];
      var point0 = this._coordinateMap(points[i][0][0] * maxX / maxXValue,
        (period - points[i][0][1] + 1) * maxX / maxYValue, (points[i][0][2] - minZValue) * maxZ / ZRange);
      points_2d.push(point0);
      for (var j = step; j < points[i].length; j += step) {
        var zValue = points[i][j][2];
        /**
         * 当step ！=1时，取step范围内峰值，避免错过波峰波谷
         */
        for (var k = 1; k < step; k++) {
          if (Math.abs(zValue) < Math.abs(points[i][j - k][2])) {
            zValue = points[i][j - k][2];
          }
        }
        var point = this._coordinateMap(points[i][j][0] * maxX / maxXValue,
          (period - points[i][j][1] + 1) * maxX / maxYValue, (zValue - minZValue) * maxZ / ZRange);
        points_2d.push(point);
      }
      this.items.push({
        type: 'line',
        path: points_2d,
        fill: this.$options.colors[2]
      });
    }
  }
  DrawPD.prototype.draw = function (period) {
    let ctx = this.$options.canvas.getContext("2d")
    ctx.clearRect(0, 0, this.$options.width, this.$options.height);
    CanvasDraw(ctx, this.axes);
    this._getLine(period);
    CanvasDraw(ctx, this.items);
  }
}

function DrawPD(options) {
  if (!(this instanceof DrawPD)) {
    throw 'Vue is a constructor and should be called with the `new` keyword'
  }
  this._init(options)
  this._initAxis()
}

initMixin(DrawPD)

export default DrawPD
