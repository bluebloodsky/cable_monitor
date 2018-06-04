/*监测对象分为电缆线路监测和隧道监测*/
export const MONITOR_TYPES = [{
  name: 'GILC',
  name_cn: 'GIL电弧定位',
  type: 'GIL_MONITOR',
  icon: 'icon-flag'
}, {
  name: 'SPDC',
  name_cn: '局部放电监测',
  type: 'WIRE_MONITOR',
  icon: 'icon-flashlight'
}, {
  name: 'SPTR',
  name_cn: '载流量及护层电流监测',
  type: 'WIRE_MONITOR',
  icon: 'icon-tailor'
}, {
  name: 'SSBH',
  name_cn: '绝缘介损监测',
  type: 'WIRE_MONITOR',
  icon: 'icon-integral'
}, {
  name: 'STMP',
  name_cn: '光纤测温监测',
  type: 'WIRE_MONITOR',
  icon: 'icon-accessory'
}, {
  name: 'ENVR',
  name_cn: '环境监测',
  type: 'SECTION_MONITOR',
  icon: 'icon-workbench'
}, {
  name: 'SPDC',
  name_cn: '安防监测',
  type: 'SECTION_MONITOR',
  icon: 'icon-live'
}, {
  name: 'CAMR',
  name_cn: '视频监控',
  type: 'CAMR_MONITOR',
  icon: 'icon-camera'
}]

export const MONITOR_PARAMS = [{
  name: 'AppPaDsch',
  name_cn: '视在局放放电量',
  unit: 'pC',
  show_type:'Txt',
  monitor_type: 'GILC'
}, {
  name: 'AppPaDsch',
  name_cn: '视在局放放电量',
  unit: 'pC',
  show_type:'Radial',
  monitor_type: 'SPDC'
}, {
  name: 'TotCurrent',
  name_cn: '护层环流电流',
  show_type:'Radial',
  unit: 'A',
  monitor_type: 'SPTR'
}, {
  name: 'LosFact',
  name_cn: '介质损耗因素',
  unit: '%',
  show_type:'Radial',
  monitor_type: 'SSBH'
}, {
  name: 'temp',
  name_cn: '温度',
  unit: '℃',
  show_type:'Linear',
  monitor_type: 'STMP'
}, {
  name: 'gasTmp',
  name_cn: '空气温度',
  unit: '℃',
  show_type:'Linear',
  monitor_type: 'ENVR'
}, {
  name: 'humity',
  name_cn: '空气湿度',
  unit: '%',
  show_type:'Radial',
  monitor_type: 'ENVR'
}, {
  name: 'waterLevel',
  name_cn: '水位',
  unit: 'mm',
  show_type:'Radial',
  monitor_type: 'ENVR'
}]
