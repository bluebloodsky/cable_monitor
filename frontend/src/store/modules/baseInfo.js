const state = {
  monitorTypes: [{
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
}

const getters ={
    monitorTypes: state=>state.monitorTypes
}

const mutations={
    setMonitorTypes(state,{items}){
        sate.monitorTypes = items
    }
}