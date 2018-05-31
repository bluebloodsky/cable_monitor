/*画箭头，根据两个点*/
const getArrowPath = (point1, point2) => {
  let point3, point4, point5, point6, point7;
  let arrowLength = 10,
    arrowWidth = 4,
    lineWidth = 1;
  let angle = Math.atan((point2[1] - point1[1]) / (point2[0] - point1[0]));

  point3 = [point2[0] + arrowWidth * Math.sin(angle), point2[1] - arrowWidth * Math.cos(angle)];
  point5 = [point2[0] - arrowWidth * Math.sin(angle), point2[1] + arrowWidth * Math.cos(angle)];
  if (point2[0] >= point1[0]) {
    point4 = [point2[0] + arrowLength * Math.cos(angle), point2[1] + arrowLength * Math.sin(angle)];
  } else {
    point4 = [point2[0] - arrowLength * Math.cos(angle), point2[1] - arrowLength * Math.sin(angle)];
  }
  point6 = [point2[0] - lineWidth * Math.sin(angle), point2[1] + lineWidth * Math.cos(angle)];
  point7 = [point1[0] - lineWidth * Math.sin(angle), point1[1] + lineWidth * Math.cos(angle)];
  return [point1, point2, point3, point4, point5, point6, point7];
}

const drawPic = (ctx, items) => {
  items.map(item => {
    ctx.save();
    if (item.type == "text") {
      if (item.font) {
        ctx.font = item.font;
      }
      if (item.rotate) {
        ctx.translate(item.x, item.y);
        ctx.rotate(item.rotate * Math.PI / 180);
        ctx.fillText(item.text, 0, 0);
      } else {
        ctx.fillText(item.text, item.x, item.y);
      }
    } else if (item.type == "line") {
      ctx.beginPath();
      item.path.map((point, j) => {
        if (j == 0) {
          ctx.moveTo(point[0], point[1]);
        } else {
          ctx.lineTo(point[0], point[1]);
        }
      });
      ctx.strokeStyle = item.fill;
      ctx.stroke();
    } else if (item.type == "path") {
      ctx.beginPath();
      item.path.map((point, j) => {
        if (j == 0) {
          ctx.moveTo(point[0], point[1]);
        } else {
          ctx.lineTo(point[0], point[1]);
        }
      });
      ctx.fillStyle = item.fill;
      ctx.fill();
    } else if (item.type == "rect") {
      ctx.fillStyle = item.fill;
      ctx.fillRect(item.x, item.y, item.width, item.height);
    } else if (item.type == "circle") {
      ctx.beginPath();
      ctx.fillStyle = item.fill;
      ctx.arc(item.x, item.y, item.radius, 0, 2 * Math.PI, true); //2*Math.PI是360° 
      ctx.fill();
    }
    ctx.restore();
  })
}

///绘制局放NQφ 三维分析图
/*param为json对象，格式为：
{
  canvas:$("#canvas"),
  points: //根据周波进行分类
  [
    [
    [1,1,2],[2,1,2]
    ],[
    [1,2,2],[2,2,2]
    ]
  ]
  ]，
  title:'局放图谱'，
  xDesc:'x轴描述'，
  zDesc:'z轴描述'
}
*/

export const drawPD = function(param){
  var canvas = param.canvas;
  var ctx = canvas.getContext("2d");
  var points = param.points;
  var title = "局放图谱";
  if (param.title) {
    title = param.title;
  }
  var xDesc = param.xDesc;
  var zDesc = param.zDesc;
  var width = canvas.width
  var height = canvas.height
  var phaseX = 0;
  var phaseY = Math.PI / 4;
  var colors = ['grey', 'blue', 'red', '#808A87', '#228B22', '#FF8000', '#7FFFD4', 'red'];
  var step = 1;
  var items = [];
  var originX = 0.5 * width;
  var originY = 0.35 * height;
  var axes = [];
  var convert2point = function (x, y, z) {
    var tmpX = Math.cos(phaseX) * x - Math.cos(phaseY) * y;
    var tmpY = Math.sin(phaseX) * x + Math.sin(phaseY) * y - z;
    return [tmpX + originX, tmpY + originY];
  };
  var getLine = function (period) {
    var maxX = width / 2;
    var maxZ = height / 5;
    var maxXValue = 0; //x
    var maxYValue = 0; //y
    var maxZValue = 0; //z
    var minZValue = 0; //-z
    for (var i = 0; i < points.length; i++) {
      for (var j = 0; j < points[i].length; j++) {
        if (parseFloat(maxXValue) < parseFloat(points[i][j][0])) {
          maxXValue = points[i][j][0];
        }
        if (parseFloat(maxYValue) < parseFloat(points[i][j][1])) {
          maxYValue = points[i][j][1];
        }
        if (parseFloat(maxZValue) < parseFloat(points[i][j][2])) {
          maxZValue = parseFloat(points[i][j][2]);
        }
        if (parseFloat(minZValue) > parseFloat(points[i][j][2])) {
          minZValue = parseFloat(points[i][j][2]);
        }
      }
    };
    var ZRange = (maxZValue - minZValue) * 1.5;
    if (ZRange == 0) {
      ZRange = 1;
    }
    //画坐标轴量程
    for (var i = 0; i < 5; i++) {
      items.push({
        type: 'text',
        x: convert2point(0, maxX, maxZ * i / 4)[0] - 45,
        y: convert2point(0, maxX, maxZ * i / 4)[1],
        text: (ZRange * i / 4 + minZValue).toFixed(2)
      }, {
        type: 'text',
        x: convert2point(maxX * i / 4, maxX, 0)[0] - 10,
        y: convert2point(maxX * i / 4, maxX, 0)[1] + 15,
        text: maxXValue * i / 4
      })
    }
    //将数据转化为三维图上的点,并将前后两个点依次相连成线
    for (var i = 0; i < period; i++) {
      var points_2d = [];
      var point0 = convert2point(points[i][0][0] * maxX / maxXValue,
        (period - points[i][0][1] + 1) * maxX / maxYValue, (points[i][0][2] - minZValue) * maxZ / ZRange);
      points_2d.push(point0);
      for (var j = step; j < points[i].length; j += step) {
        var zValue = points[i][j][2];
        for (var k = 1; k < step; k++) {
          if (Math.abs(zValue) < Math.abs(points[i][j - k][2])) {
            zValue = points[i][j - k][2];
          }
        }
        var point = convert2point(points[i][j][0] * maxX / maxXValue,
          (period - points[i][j][1] + 1) * maxX / maxYValue, (zValue - minZValue) * maxZ / ZRange);

        points_2d.push(point);
      }
      items.push({
        type: 'line',
        path: points_2d,
        fill: colors[2]
      });
    }
  };
  var InitAxes = function () {
    var maxX = width / 2;
    var maxZ = height / 5;
    axes = [];
    if (title != null) {
      axes.push({
        type: 'text',
        x: width / 2,
        y: 20,
        text: title,
        font: '14px Arial'
      });
    }
    if (xDesc != null) {
      axes.push({
        type: 'text',
        x: convert2point(maxX, maxX, 0)[0],
        y: convert2point(maxX, maxX, 0)[1] + 30,
        text: xDesc
      });
    }
    if (zDesc != null) {
      axes.push({
        type: 'text',
        x: convert2point(0, maxX, maxZ)[0] - 55,
        y: convert2point(0, maxX, maxZ)[1],
        text: zDesc,
        rotate: 270
      });
    }
    for (var i = 0; i < 5; i++) {
      axes.push({
        type: 'line',
        path: [convert2point(maxX * i / 4, 0, 0), convert2point(maxX * i / 4, 0, maxZ)], //XZ面Z轴
        fill: colors[0]
      });
      axes.push({
        type: 'line',
        path: [convert2point(0, 0, maxZ * i / 4), convert2point(maxX, 0, maxZ * i / 4)], //XZ面X轴
        fill: colors[0]
      });

      axes.push({
        type: 'line',
        path: [convert2point(maxX * i / 4, 0, 0), convert2point(maxX * i / 4, maxX, 0)], //XY面Y轴
        fill: colors[0]
      });

      axes.push({
        type: 'line',
        path: [convert2point(0, 0, maxZ * i / 4), convert2point(0, maxX, maxZ * i / 4)], //YZ面Y轴
        fill: colors[0]
      });
      axes.push({
        type: 'line',
        path: [convert2point(0, maxX * i / 4, 0), convert2point(0, maxX * i / 4, maxZ)], //YZ面Z轴
        fill: colors[0]
      });
    }
    for (var i = 0; i < points.length + 1; i++) {
      axes.push({
        type: 'line',
        path: [convert2point(0, maxX * i / points.length, 0), convert2point(maxX, maxX * i / points.length, 0)], //XY面X轴
        fill: colors[1]
      });
    }
  };
  InitAxes();
  this.drawPD = function () {
    var i = 1;
    var timer = setInterval(function () {
      if (i == points.length) {
        clearInterval(timer); //清除定时器
      };
      ctx.clearRect(0, 0, width, height);
      drawPic(ctx, axes);
      items = [];
      getLine(i);
      drawPic(ctx, items);
      i++;
    }, 85);
  };
};


//三比值法结果,参数为{'H2':1.1,'CH4':1.4,'C2H2':0.3,'C2H4':1.1,'C2H6':2.1}
export const getTriRatioResult = data => {
  if (data['H2'] * data['C2H4'] * data['C2H6'] == 0) {
    return {
      conclusion: '',
      instruction: ''
    };
  }
  var a = data['C2H2'] / data['C2H4'];
  var b = data['CH4'] / data['H2'];
  var c = data['C2H4'] / data['C2H6'];
  var code = [];

  if (a < 0.1) {
    code.push(0);
  } else if (a < 3) {
    code.push(1);
  } else {
    code.push(2);
  }

  if (b < 0.1) {
    code.push(1);
  } else if (b < 1) {
    code.push(0);
  } else {
    code.push(2);
  }

  if (c < 1) {
    code.push(0);
  } else if (c < 3) {
    code.push(1);
  } else {
    code.push(2);
  }

  var result = {
    conclusion: '正常',
    instruction: ''
  };
  if (code[0] == 0) {
    if (code[1] == 0 && code[2] == 1) {
      result.conclusion = "低温过热（低于150℃）";
      result.instruction = "绝缘导线过热，注意CO和CO2含量和CO2/CO值";
    } else if (code[1] == 2 && code[2] == 0) {
      result.conclusion = "低温过热（150-300）℃";
      result.instruction = "分接开关接触不良，引线夹件螺丝松动或接头焊接不良," +
        "涡流引起铜过热，铁芯漏磁，局部短路，层间绝缘不良，铁芯多点接等";
    } else if (code[1] == 2 && code[2] == 1) {
      result.conclusion = "中温过热（300-700）℃";
      result.instruction = "分接开关接触不良，引线夹件螺丝松动或接头焊接不良，" +
        "涡流引起铜过热，铁芯漏磁，局部短路，层间绝缘不良，铁芯多点接等";
    } else if (code[2] == 2) {
      result.conclusion = "高温过热（高于700℃）";
      result.instruction = "分接开关接触不良，引线夹件螺丝松动或接头焊接不良，" +
        "涡流引起铜过热，铁芯漏磁，局部短路，层间绝缘不良，铁芯多点接等";
    } else if (code[1] == 1 && code[2] == 0) {
      result.conclusion = "局部放电";
      result.instruction = "高湿度，高含量气量引起油中低能量密度的局部放电";
    }
  } else if (code[0] == 2) {
    if (code[1] == 2) {
      result.conclusion = "低能放电兼过热";
    } else {
      result.conclusion = "低能放电";
    }
    result.instruction = "引线对电位未固定的部件之间连续火花放电，分接抽头引线和油隙闪络，" +
      "不同电位之间的油中火花放电或悬浮电位之间的火花放电";
  } else if (code[0] == 1) {
    if (code[1] == 2) {
      result.conclusion = "电弧放电兼过热";
    } else {
      result.conclusion = "电弧放电";
    }
    result.instruction = "线圈匝间，层间短路，相间闪络，分接头引线间油隙闪络、引线对箱壳放电、" +
      "线圈熔断、分接开关飞弧、因环路电流引起电弧、引线对其他接地体放电等";
  }
  return result;
};

export const drawDavidTriangle = function(param) {
  var canvas = param.canvas;
  var data = param.data;
  var descAdjustX = 10;
  var descAdjustY = 12;
  var radius = 3;
  var anglePhase = Math.PI / 3;
  var graphicStartX = 100;
  var graphicStartY = 100;
  var descWidth = 100;
  var descHeight = 15;
  var descLineSpace = 25;
  var descFont = "14px Arial";
  var triangleLength = 220;
  var descStartX = graphicStartX + triangleLength * 1.2;
  var descStartY = graphicStartY;
  var colors = ['#7FFF00', '#B0E0E6', '#FA8072', '#808A87', '#228B22', '#FF8000', '#7FFFD4', 'red'];
  var ctx = canvas.getContext("2d");
  var pointLeft = [graphicStartX, graphicStartY + triangleLength * Math.sin(anglePhase)]
  var pointTop = [graphicStartX + triangleLength * 0.5, graphicStartY];
  var pointRight = [graphicStartX + triangleLength, graphicStartY + triangleLength * Math.sin(anglePhase)];
  var triangleitems = [];
  //计算大卫三角结果
  var getDavidResult = function (data) {
    var total = data['CH4'] + data['C2H4'] + data['C2H2'];
    var a = data['CH4'] / total;
    var b = data['C2H4'] / total;
    var c = data['C2H2'] / total;
    if (a > 0.98) {
      return 'PD—局部放电';
    } else if (b < 0.23 && c > 0.13) {
      return 'D1—低能放电';
    } else if ((b > 0.23 && b < 0.38 && c > 0.13) || (b > 0.38 && c > 0.29)) {
      return 'D2—高能放电';
    } else if (a < 0.98 && b < 0.1 && c < 0.04) {
      return 'T1—热程故障,t<300℃';
    } else if (b > 0.1 && b < 0.5 && c < 0.04) {
      return 'T2—热故障,300℃<t<700℃';
    } else if (b > 0.5 && c < 0.15) {
      return 'T3—热故障,t>700℃';
    } else {
      return 'D或者T故障';
    }
  };

  var convertPercentToPoint = function (percentCH4, percentC2H4) {
    var tmpY = pointLeft[1] - triangleLength * Math.sin(anglePhase) * percentCH4 / 100;
    var tmpX = pointLeft[0] + percentCH4 / 100 * triangleLength * 0.5 + triangleLength * percentC2H4 / 100;
    return [tmpX, tmpY];
  };
  var drawResult = function (data) {
    var total = data['CH4'] + data['C2H4'] + data['C2H2'];
    if (total == '') {
      return;
    }
    var point = convertPercentToPoint(data['CH4'] * 100 / total, data['C2H4'] * 100 / total);
    resultItems = [{
      type: 'circle',
      x: point[0],
      y: point[1],
      radius: radius,
      fill: colors[7]
    }];
    resultItems.push({
      type: 'text',
      x: descStartX,
      y: descStartY + descLineSpace * (7 + 1) + descAdjustY,
      text: '诊断结果 ',
      font: descFont
    }, {
      type: 'text',
      x: descStartX + descWidth + descAdjustX,
      y: descStartY + descLineSpace * (7 + 1) + descAdjustY,
      text: getDavidResult(data),
      font: descFont
    });
    return resultItems;
  };
  var InitTriangle = function () {
    var descContent = ['PD-局部放电', 'D1-低能放电', 'D2-高能放电', 'T1-热故障', 'T2-热故障', 'T3-热故障', 'D + T'];

    //大卫三角形内部
    {
      var drawPoints = [];
      //PD
      drawPoints.push(pointTop);
      drawPoints.push(convertPercentToPoint(98, 0));
      drawPoints.push(convertPercentToPoint(98, 2));
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[0]
      });

      //D1
      drawPoints = [];
      drawPoints.push(convertPercentToPoint(100 - 13, 0));
      drawPoints.push(convertPercentToPoint(100 - 13 - 23, 23));
      drawPoints.push(convertPercentToPoint(0, 23));
      drawPoints.push(pointLeft);
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[1]
      });

      //D2
      drawPoints = [];
      drawPoints.push(convertPercentToPoint(0, 23));
      drawPoints.push(convertPercentToPoint(100 - 13 - 23, 23));
      drawPoints.push(convertPercentToPoint(100 - 38 - 13, 38));
      drawPoints.push(convertPercentToPoint(100 - 38 - 29, 38));
      drawPoints.push(convertPercentToPoint(0, 100 - 29));
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[2]
      });

      //T1
      drawPoints = [];
      drawPoints.push(convertPercentToPoint(100 - 4, 0));
      drawPoints.push(convertPercentToPoint(98, 0));
      drawPoints.push(convertPercentToPoint(98, 2));
      drawPoints.push(convertPercentToPoint(100 - 10, 10));
      drawPoints.push(convertPercentToPoint(100 - 10 - 4, 10));
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[3]
      });

      //T2
      drawPoints = [];
      drawPoints.push(convertPercentToPoint(100 - 10, 10));
      drawPoints.push(convertPercentToPoint(100 - 10 - 4, 10));
      drawPoints.push(convertPercentToPoint(100 - 50 - 4, 50));
      drawPoints.push(convertPercentToPoint(100 - 50, 50));
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[4]
      });

      //T3
      drawPoints = [];
      drawPoints.push(convertPercentToPoint(100 - 50, 50));
      drawPoints.push(convertPercentToPoint(100 - 50 - 15, 50));
      drawPoints.push(convertPercentToPoint(0, 100 - 15));
      drawPoints.push(pointRight);
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[5]
      });

      //D+T
      drawPoints = [];
      drawPoints.push(convertPercentToPoint(100 - 4, 0));
      drawPoints.push(convertPercentToPoint(100 - 13, 0));
      drawPoints.push(convertPercentToPoint(100 - 38 - 13, 38));
      drawPoints.push(convertPercentToPoint(100 - 38 - 29, 38));
      drawPoints.push(convertPercentToPoint(0, 100 - 29));
      drawPoints.push(convertPercentToPoint(0, 100 - 15));
      drawPoints.push(convertPercentToPoint(100 - 50 - 15, 50));
      drawPoints.push(convertPercentToPoint(100 - 50 - 4, 50));
      triangleitems.push({
        type: 'path',
        path: drawPoints, //路径
        fill: colors[6]
      });
    }
    //大卫三角形坐标
    {
      var dotLinePercent = 2;
      for (var i = 0; i < 6; i++) {
        var pointCH4 = convertPercentToPoint(20 * i, 0);
        var point2CH4 = convertPercentToPoint(20 * i, -dotLinePercent);
        var textLocate = convertPercentToPoint(20 * i, -15);
        triangleitems.push({
          type: 'line',
          path: [pointCH4, point2CH4], //路径
          fill: 'balck'
        }, {
          type: 'text',
          x: textLocate[0],
          y: textLocate[1],
          text: i * 20,
          rotate: 300
        });

        var pointC2H4 = convertPercentToPoint(100 - 20 * i, 20 * i);
        var point2C2H4 = convertPercentToPoint(100 - 20 * i + dotLinePercent, 20 * i);
        textLocate = convertPercentToPoint(100 - 20 * i + 5, 20 * i);
        triangleitems.push({
          type: 'path',
          path: [pointC2H4, point2C2H4], //路径
          fill: 'balck'
        }, {
          type: 'text',
          x: textLocate[0],
          y: textLocate[1],
          text: i * 20,
          rotate: 60
        });

        var pointC2H2 = convertPercentToPoint(0, 100 - 20 * i);
        var point2C2H2 = convertPercentToPoint(-dotLinePercent, 100 - 20 * i + dotLinePercent);
        textLocate = convertPercentToPoint(-5, 100 - 20 * i + 5);
        triangleitems.push({
          type: 'path',
          path: [pointC2H2, point2C2H2], //路径
          fill: 'balck'
        }, {
          type: 'text',
          x: textLocate[0],
          y: textLocate[1],
          text: i * 20,
        });
      }
    }
    //箭头及描述
    {
      var arrowPath = getArrowPath(convertPercentToPoint(40, -25), convertPercentToPoint(80, -25));
      var textLocate = convertPercentToPoint(60, -30);
      triangleitems.push({
        type: 'path',
        path: arrowPath, //路径
        fill: 'balck'
      }, {
        type: 'text',
        x: textLocate[0],
        y: textLocate[1],
        text: '%CH4',
        rotate: 300
      });

      arrowPath = getArrowPath(convertPercentToPoint(115 - 40, 40), convertPercentToPoint(115 - 80, 80));
      textLocate = convertPercentToPoint(60, 60);
      triangleitems.push({
        type: 'path',
        path: arrowPath, //路径
        fill: 'balck'
      }, {
        type: 'text',
        x: textLocate[0],
        y: textLocate[1],
        text: '%C2H4',
        rotate: 60
      });

      arrowPath = getArrowPath(convertPercentToPoint(-10, 115 - 40), convertPercentToPoint(-10, 115 - 80));
      textLocate = convertPercentToPoint(-20, 120 - 70);
      triangleitems.push({
        type: 'path',
        path: arrowPath, //路径
        fill: 'balck'
      }, {
        type: 'text',
        x: textLocate[0],
        y: textLocate[1],
        text: '%C2H2',
      });
    }

    triangleitems.push({
      type: 'text',
      x: descStartX + 5,
      y: descStartY,
      text: '符号说明：',
      font: descFont,
    });
    for (var i = 0; i < descContent.length; i++) {
      triangleitems.push({
        type: 'rect',
        fill: colors[i],
        width: descWidth,
        height: descHeight,
        x: descStartX,
        y: descStartY + descLineSpace * (i + 1)
      });
      triangleitems.push({
        type: 'text',
        x: descStartX + descWidth + descAdjustX,
        y: descStartY + descLineSpace * (i + 1) + descAdjustY,
        text: descContent[i],
        font: descFont
      });
    }
  };
  InitTriangle();
  this.drawDavid = function () {
    ctx.clearRect(0, 0, canvas.width(), canvas.height());
    drawPic(ctx, triangleitems);
    if (null != data) {
      var resultItems = drawResult(data);
      drawPic(ctx, resultItems);
    }
  };
};
