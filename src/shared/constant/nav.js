export const NAV_MENUS = [{
  name_cn: '首页',
  icon: 'icon-homepage',
  url: 'desktop'
  // }, {
  //   name_cn: '实时数据',
  //   icon: 'icon-time',
  //   url: 'on-data'
}, {
  name_cn: '数据总览',
  icon: 'icon-dynamic',
  url: 'data'
}, {
  name_cn: '告警记录',
  icon: 'icon-remind',
  url: 'alarm'
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
    label: '监测类型配置'
  }, {
    label: '监测参数配置'
  }]
}, {
  label: '设备信息配置',
  children: [{
    label: '电缆通道信息配置'
  }, {
    label: '电缆线路信息配置'
  }, {
    label: '监测设备配置'
  }]
}]
