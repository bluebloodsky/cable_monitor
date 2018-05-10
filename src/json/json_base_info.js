/*监测对象分为电缆线路监测和隧道监测*/
export const MONITOR_TYPES = [{
  name: 'SPDC',
  name_cn: '局部放电监测',
  type:'WIRE_MONITOR',
  icon: 'icon-flashlight'
}, {
  name: 'SPTR',
  name_cn: '载流量及护层电流监测',
  type:'WIRE_MONITOR',
  icon: 'icon-integral'
}, {
  name: 'SSBH',
  name_cn: '绝缘介损监测',
  type:'WIRE_MONITOR',
  icon: 'icon-flashlight'
}, {
  name: 'STMP',
  name_cn: '光纤测温监测',
  type:'WIRE_MONITOR',
  icon: 'icon-flag'
}, {
  name: 'ENVR',
  name_cn: '环境监测',
  type:'TUNNEL_MONITOR',
  icon: 'icon-flashlight'
}, {
  name: 'CAMR',
  name_cn: '视频监控',
  type:'TUNNEL_MONITOR',
  icon: 'icon-flashlight'
}, {
  name: 'SPDC',
  name_cn: '安防监测',
  type:'TUNNEL_MONITOR',
  icon: 'icon-flashlight'
}]

export const MONITOR_PARAMS =[{
	name:'AppPaDsch',
	name_cn:'视在局放放电量',
	unit:'pC',
	monitor_type:'SPDC'
},{
	name:'TotCurrent',
	name_cn:'护层环流电流',
	unit:'A',
	monitor_type:'SPTR'
},{
	name:'LosFact',
	name_cn:'介质损耗因素',
	unit:'%',
	monitor_type:'SSBH'
},{
	name:'temp',
	name_cn:'温度',
	unit:'℃',
	monitor_type:'STMP'
},{
	name:'gasTmp',
	name_cn:'空气温度',
	unit:'℃',
	monitor_type:'ENVR'
},{
	name:'humity',
	name_cn:'空气湿度',
	unit:'%',
	monitor_type:'ENVR'
},{
	name:'waterLevel',
	name_cn:'水位',
	unit:'%',
	monitor_type:'ENVR'
}]
