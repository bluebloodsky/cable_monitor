export const TUNNELS = [{
  name: 'xf',
  name_cn: '下凤电缆隧道'
}]
export const WIRES = [{
  name: 'guanghua1',
  name_cn: '220kV光华1回路'
}, {
  name: 'guanghua2',
  name_cn: '220kV光华2回路'
}]

export const SECTIONS = [{
  name: 'fangqu1',
  name_cn: '1#防区'
},{
  name: 'fangqu2',
  name_cn: '2#防区'
},{
  name: 'fangqu3',
  name_cn: '3#防区'
}]

export const MONITOR_DEVICE = [{
	name:'jf1',
	name_cn:'局放监测点1',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu1',
	phase:'A相'
},{
	name:'jf2',
	name_cn:'局放监测点2',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu1',
	phase:'B相'
},{
	name:'jf3',
	name_cn:'局放监测点3',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu1',
	phase:'C相'
},{
	name:'jf4',
	name_cn:'局放监测点4',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu2',
	phase:'A相'
},{
	name:'jf5',
	name_cn:'局放监测点5',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu2',
	phase:'B相'
},{
	name:'jf6',
	name_cn:'局放监测点6',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu2',
	phase:'C相'
},{
	name:'jf7',
	name_cn:'局放监测点7',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu2',
	phase:'A相'
},{
	name:'jf8',
	name_cn:'局放监测点8',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu2',
	phase:'B相'
},{
	name:'jf9',
	name_cn:'局放监测点9',
	monitor_type:'SPDC',
	wire:'guanghua1',
	section:'fangqu2',
	phase:'C相' 
},{
	name:'jf10',
	name_cn:'局放监测点10',
	monitor_type:'SPDC',
	wire:'guanghua2',
	section:'fangqu2',
	phase:'A相' 
},{
	name:'hj1',
	name_cn:'环境监测点1',
	monitor_type:'ENVR',
	section:'fangqu1',	
},{
	name:'sp1',
	name_cn:'摄像头1',
	monitor_type:'CAMR',
	section:'fangqu1',
	location:'http://61.83.161.2:10000/mjpeg.cgi?channel=1&user=guest&password=guest&time=1524039431169'
}]