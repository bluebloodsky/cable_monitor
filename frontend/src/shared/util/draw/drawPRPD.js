import {
  CanvasDraw,
  CalcFireColor
} from './tool'

function initMixin(DrawPRPD) {
  DrawPRPD.prototype = {
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
        title: 'PRPD图',
        xDesc: '相位',
        yDesc: '幅值',
        colors: ['lightgrey', 'red', 'black', 'black', 'red', 'blue']
      }
    },
    items: [],
    axes: [],
    get _coordinate() {
      return {
        originX: 80,
        originY: this._height / 2,
        maxX: this._width - 100,
        maxY: this._height / 2 - 40
      }
    },
    _coordinateMap: function (x, y) {
      return [x + this._coordinate.originX, -y + this._coordinate.originY];
    },
    _initAxis: function () {
      let maxX = this._coordinate.maxX
      let maxY = this._coordinate.maxY
      this.axes = [];
      this.$options.title &&
        this.axes.push({
          type: 'text',
          x: maxX / 2,
          y: 20,
          text: this.$options.title,
          font: '14px Arial',
          fill: this.$options.colors[3]
        })
      this.$options.xDesc &&
        this.axes.push({
          type: 'text',
          x: this._coordinateMap(maxX, -maxY)[0] - 15,
          y: this._coordinateMap(maxX, -maxY)[1] + 35,
          text: this.$options.xDesc,
          fill: this.$options.colors[3]
        })

      this.$options.yDesc &&
        this.axes.push({
          type: 'text',
          x: this._coordinateMap(0, maxY)[0],
          y: this._coordinateMap(0, maxY)[1] - 10,
          text: this.$options.yDesc,
          rotate: 270,
          fill: this.$options.colors[3]
        })
      for (let i = 0; i < 5; i++) {
        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(maxX * i / 4, -maxY), this._coordinateMap(maxX * i / 4, maxY)],
          fill: this.$options.colors[0]
        });

        this.axes.push({
          type: 'line',
          path: [this._coordinateMap(0, maxY * (i - 2) / 2), this._coordinateMap(maxX, maxY * (i - 2) / 2)],
          fill: this.$options.colors[0]
        });

        this.axes.push({
          type: 'text',
          x: this._coordinateMap(maxX * i / 4, -maxY)[0] - 10,
          y: this._coordinateMap(maxX * i / 4, -maxY)[1] + 15,
          text: 90 * i,
          fill: this.$options.colors[3]
        });
      }

      let sine = [],
        maxXValue = Math.PI * 2,
        maxYValue = 1
      for (let i = 0; i < 300; i++) {
        let x = i * maxXValue / 300
        let y = Math.sin(x)
        sine.push(this._coordinateMap(x * maxX / maxXValue, y * maxY / maxYValue))
      }
      this.axes.push({
        type: 'line',
        path: sine,
        fill: this.$options.colors[0]
      });

      //绘制图例
      let maxNum = 100
      for(let i =0 ; i < maxNum; i ++){
        this.axes.push({
          type:'rect' ,
          x: 5 ,
          y: this._coordinateMap(0 , (i+1) * maxY * 2 / maxNum - maxY )[1],
          width: 10,
          height:maxY * 2/ maxNum +1 ,
          fill:CalcFireColor(i , 0 , maxNum)
        })
      }
    },
    _getLine: function (period) {
      let maxX = this._coordinate.maxX
      let maxY = this._coordinate.maxY
      let points = this.$options.points
      let step = this.$options.step

      this.items = []

      let maxXValue = points[0][0][0]; //x
      let maxYValue = points[0][0][2]; //y
      let minYValue = points[0][0][2]; //y

      let [i , j  , n] = [0 , 0 , n]
      for (i = 0; i < points.length; i++) {
        for (j = 0; j < points[i].length; j++) {
          if (maxXValue < parseFloat(points[i][j][0])) {
            maxXValue = parseFloat(points[i][j][0])
          }
          if (maxYValue < parseFloat(points[i][j][2])) {
            maxYValue = parseFloat(points[i][j][2])
          }
          if (minYValue > parseFloat(points[i][j][2])) {
            minYValue = parseFloat(points[i][j][2])
          }
        }
      }

      this.items.push({
        type: 'text',
        x: maxX / 4,
        y: 20,
        text: '最大值：' + maxYValue.toFixed(2),
        fill: this.$options.colors[4]
      }, {
        type: 'text',
        x: maxX * 3 / 4,
        y: 20,
        text: '最小值：' + minYValue.toFixed(2),
        fill: this.$options.colors[5]
      })

      maxYValue = Math.round(Math.max(Math.abs(maxYValue), Math.abs(minYValue)) * 1.2 / 10) * 10;
      if (maxYValue == 0) {
        maxYValue = 10
      }
      //画y坐标轴量程
      for (i = 0; i < 5; i++) {
        this.items.push({
          type: 'text',
          x: this._coordinateMap(0, maxY * (i - 2) / 2)[0] - 45,
          y: this._coordinateMap(0, maxY * (i - 2) / 2)[1],
          text: (maxYValue * (i - 2) / 2).toFixed(2),
          fill: this.$options.colors[3]
        })
      }

      for (i = 0; i < 360; i++) {
        let pulse = []
        for (let j = 0; j < period; j++) {
          if (points[j][i]) {
            pulse.push(points[j][i][2])
          }
        }
        pulse.sort((a, b) => a - b)

        for(j = 0 , n = 0 ; j < pulse.length ; j++){
          n++
          if(j == (pulse.length -1) || pulse[j+1] -pulse[j] > 0){ // 值变化了
            let point = this._coordinateMap( i  * maxX / maxXValue,  pulse[j]* maxY / maxYValue);
            this.items.push({
              type: 'circle',
              x: point[0],
              y: point[1],
              radius: 0.8,
              fill: CalcFireColor(n , 1 , 80)
            })
            n = 0
          }
        }

        // for(let k = 0 , n = 1 ; k < pulse.length ; k++){
        //               let point = this._coordinateMap( i  * maxX / maxXValue,  pulse[k]* maxY / maxYValue);
        //     this.items.push({
        //       type: 'circle',
        //       x: point[0],
        //       y: point[1],
        //       radius: 1,
        //       // fill: CalcFireColor(n , 1 , 60)
        //       fill: '#000'
        //     })
        // }

      }



      // for (let i = 0; i < period; i++) {
      //   for (let j = 0; j < points[i].length; j++) {
      //     let point = this._coordinateMap(points[i][j][0] * maxX / maxXValue, points[i][j][2] * maxY / maxYValue)
      //     this.items.push({
      //       type: 'circle',
      //       x: point[0],
      //       y: point[1],
      //       radius: 0.5,
      //       fill: this.$options.colors[2]
      //     });
      //   }
      // }


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
      this._getLine(this._period);
      CanvasDraw(ctx, this.items);
    }
  }
}

function DrawPRPD(container) {
  if (!(this instanceof DrawPRPD)) {
    throw 'DrawPRPD is a constructor and should be called with the `new` keyword'
  }
  this._init(container)
}
initMixin(DrawPRPD)

export default DrawPRPD
