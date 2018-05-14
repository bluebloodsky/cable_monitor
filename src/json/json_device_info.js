export const TUNNELS = [{
  name: 'xf',
  name_cn: '下凤电缆隧道'
}]
export const WIRES = [{
  name: 'xiafeng1',
  name_cn: '500kV下凤1回',
  type: 'GIL',
}, {
  name: 'xiafeng2',
  name_cn: '500kV下凤2回',
  type: 'GIL',
}, {
  name: 'xiafeng3',
  name_cn: '220kV下凤1回',
  type: 'WIRE',
}, {
  name: 'xiafeng4',
  name_cn: '220kV下凤2回',
  type: 'WIRE',
}]

export const SECTIONS = [{
  name: 'fangqu1',
  name_cn: '1#防区',
  img_url: '/static/img/section.png'
}, {
  name: 'fangqu2',
  name_cn: '2#防区',
  img_url: '/static/img/section.png'
}, {
  name: 'fangqu3',
  name_cn: '3#防区',
  img_url: '/static/img/section.png'
}]

export const MONITOR_DEVICES = [{
  name: 'gil1',
  name_cn: 'GIL监测点1',
  monitor_type: 'GILC',
  wire: 'xiafeng1',
  section: 'fangqu1',
  phase: 'A相'
},{
  name: 'gil2',
  name_cn: 'GIL监测点2',
  monitor_type: 'GILC',
  wire: 'xiafeng1',
  section: 'fangqu1',
  phase: 'A相'
},{
  name: 'jf1',
  name_cn: '局放监测点1',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu1',
  phase: 'A相'
}, {
  name: 'jf2',
  name_cn: '局放监测点2',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu1',
  phase: 'B相'
}, {
  name: 'jf3',
  name_cn: '局放监测点3',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu1',
  phase: 'C相'
}, {
  name: 'jf4',
  name_cn: '局放监测点4',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu2',
  phase: 'A相'
}, {
  name: 'jf5',
  name_cn: '局放监测点5',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu2',
  phase: 'B相'
}, {
  name: 'jf6',
  name_cn: '局放监测点6',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu2',
  phase: 'C相'
}, {
  name: 'jf7',
  name_cn: '局放监测点7',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu2',
  phase: 'A相'
}, {
  name: 'jf8',
  name_cn: '局放监测点8',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu2',
  phase: 'B相'
}, {
  name: 'jf9',
  name_cn: '局放监测点9',
  monitor_type: 'SPDC',
  wire: 'xiafeng3',
  section: 'fangqu2',
  phase: 'C相'
}, {
  name: 'jf10',
  name_cn: '局放监测点10',
  monitor_type: 'SPDC',
  wire: 'xiafeng4',
  section: 'fangqu2',
  phase: 'A相'
}, {
  name: 'hj1',
  name_cn: '环境监测点1',
  monitor_type: 'ENVR',
  section: 'fangqu1',
}]

export const MONITOR_CAMERAS = [{
  name: 'sp1',
  name_cn: '1#防区摄像头1',
  monitor_type: 'CAMR',
  section: 'fangqu1',
  location: 'http://61.83.161.2:10000/mjpeg.cgi?channel=1&user=guest&password=guest&time=1524039431169'
},{
  name: 'sp2',
  name_cn: '1#防区摄像头2',
  monitor_type: 'CAMR',
  section: 'fangqu1',
  location: 'http://61.83.161.2:10000/mjpeg.cgi?channel=1&user=guest&password=guest&time=1524039431169'
},{
  name: 'sp3',
  name_cn: '1#防区摄像头3',
  monitor_type: 'CAMR',
  section: 'fangqu1',
  location: 'http://61.83.161.2:10000/mjpeg.cgi?channel=1&user=guest&password=guest&time=1524039431169'
},{
  name: 'sp4',
  name_cn: '1#防区摄像头4',
  monitor_type: 'CAMR',
  section: 'fangqu1',
  location: 'http://61.83.161.2:10000/mjpeg.cgi?channel=1&user=guest&password=guest&time=1524039431169'
}]
