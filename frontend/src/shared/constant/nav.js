export const NAV_MENUS = [{
  name_cn: '首页',
  icon: 'icon-homepage',
  url: 'desktop'
}, {
  name_cn: '数据总览',
  icon: 'icon-browse',
  url: 'data'
}, {
  name_cn: '告警记录',
  icon: 'icon-remind',
  url: 'alarm'
}, {
  name_cn: '巡检维护',
  icon: 'icon-workbench',
  url:'log'
}, {
  name_cn: '辅助决策',
  icon: 'icon-dynamic',
  url:'log'
}, {
  name_cn: '日志查看',
  icon: 'icon-order',
  url: 'log'
}, {
  name_cn: '配置',
  icon: 'icon-setup',
  url: 'config'
}]

export const NAV_CONFIG_TREE = [{
  label: '基本信息配置',
  children: [{
    name: 'MONITOR_TYPES',
    label: '监测类型信息',
    defaultSelected: true
  }, {
    name: 'MONITOR_PARAMS',
    label: '监测参数信息'
  }]
}, {
  label: '设备信息配置',
  children: [{
    name: 'TUNNELS',
    label: '隧道信息'
  }, {
    name: 'SECTIONS',
    label: '防区信息'
  }, {
    name: 'WIRES',
    label: '线缆信息'
  }, {
    name: 'MONITOR_DEVICES',
    label: '监测设备信息'
  }, {
    name: 'MONITOR_CAMERAS',
    label: '摄像头信息'
  }]
}, {
  label: '布局配置',
  children: [{
    name: 'WIRE_MONITOR_POSITION',
    label: '线路监测设备布局'
  }, {
    name: 'SECTION_ENVR_POSITION',
    label: '防区环境监测设备布局'
  }, {
    name: 'SECTION__POSITION',
    label: '防区安防设备布局'
  }, {
    name: 'CAMERA_LOCATION',
    label: '摄像头布局'
  }]
}]
