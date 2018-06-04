Date.prototype.addDays = function(a) { 
  this.setDate(this.getDate() + a) 
  return this
}
Date.prototype.addWeeks = function(a) { 
  this.addDays(a * 7)  
  return this
}
Date.prototype.addMonths = function(a) {
  var b = this.getDate()
  this.setMonth(this.getMonth() + a)
  if (this.getDate() < b) { 
    this.setDate(0) 
  }
  return this
}
Date.prototype.addYears = function(b) {
  var a = this.getMonth()
  this.setFullYear(this.getFullYear() + b)
  if (a < this.getMonth()) { 
    this.setDate(0) 
  }
  return this
}
Date.prototype.fromSecond = function(a) { 
  this.setTime(a * 1000) 
  return this
}
Date.prototype.toSecond = function() { 
  return this.getTime() / 1000 
}
Date.prototype.setDateTime = function(d, e, b, a, f, c) {
  this.setFullYear(d);
  this.setMonth(e);
  this.setDate(b);
  this.setHours(a);
  this.setMinutes(f);
  this.setSeconds(c)
  return this
};
Date.prototype.getYearText = function(a) { var b = this.getFullYear().toString(); if (a == 2) { b = b.substring(2, 2) } return b };
Date.prototype.monthText = function() { var a = (this.getMonth() + 1).toString(); if (a.length <= 1) { a = "0" + a } return a };
Date.prototype.dayText = function() { var a = this.getDate().toString(); if (a.length <= 1) { a = "0" + a } return a };
Date.prototype.hourText = function() { var a = this.getHours().toString(); if (a.length <= 1) { a = "0" + a } return a };
Date.prototype.minuteText = function() { var a = this.getMinutes().toString(); if (a.length <= 1) { a = "0" + a } return a };
Date.prototype.secondText = function() { var a = this.getSeconds().toString(); if (a.length <= 1) { a = "0" + a } return a };

Date.prototype.format = function(fmt) {
  var o = {
    "M+": this.getMonth() + 1, //月份 
    "d+": this.getDate(), //日 
    "h+": this.getHours(), //小时 
    "m+": this.getMinutes(), //分 
    "s+": this.getSeconds(), //秒 
    "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
    "S": this.getMilliseconds() //毫秒 
  };
  if (/(y+)/.test(fmt)) {
    fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length))
  }
  for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt))
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
  return fmt;
}

export default Date
