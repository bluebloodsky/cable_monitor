/*根据首位两个点获取箭头路径*/
export const GetArrowPath = (options) => {
  if (!options.startPoint || !options.endPoint) {
    throw "no startPoint or endPoint"
  }
  let arrowLength = options.arrowLength ? options.arrowLength : 10
  let arrowWidth = options.arrowWidth ? options.arrowWidth : 4
  let lineWidth = options.lineWidth ? options.lineWidth : 1

  let coefficientX = startPoint[0] - endPoint[0] > 0 ? -1 : 1
  let angle = Math.atan((endPoint[1] - startPoint[1]) / (endPoint[0] - startPoint[0]))
  let lineXdiff = lineWidth / 2 * Math.sin(angle)
  let lineYdiff = lineWidth / 2 * Math.cos(angle)
  let arrowLengthXDiff = coefficientX * arrowLength * Math.cos(angle)
  let arrowLengthYDiff = coefficientX * arrowLength * Math.sin(angle)
  let arrowWidthXDiff = coefficientX * arrowWidth * Math.sin(angle)
  let arrowWidthYDiff = coefficientX * arrowWidth * Math.cos(angle)

  let points = new Array(7)
  points[0] = [startPoint[0] - lineXdiff, startPoint[1] + lineYdiff]
  points[6] = [startPoint[0] + lineXdiff, startPoint[1] - lineYdiff]
  points[3] = endPoint

  points[1] = [points[3][0] - arrowLengthXDiff * 0.8 - lineXdiff, points[3][1] - arrowLengthYDiff * 0.8 + lineYdiff]
  points[5] = [points[3][0] - arrowLengthXDiff * 0.8 + lineXdiff, points[3][1] - arrowLengthYDiff * 0.8 - lineYdiff]

  points[2] = [points[3][0] - arrowLengthXDiff - arrowWidthXDiff, points[3][1] - arrowLengthYDiff + arrowWidthYDiff]
  points[4] = [points[3][0] - arrowLengthXDiff + arrowWidthXDiff, points[3][1] - arrowLengthYDiff - arrowWidthYDiff]

  return points
}

export const CanvasDraw = (ctx, items) => {
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
