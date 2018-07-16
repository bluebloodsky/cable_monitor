const state = {
  monitorTypes: [],
  monitorParams: [],
  tunnels: [],
  sections: [],
  wires: [],
  monitorDevices: [],
  cameras: []
}
const getters = {
  monitorTypes: state => state.user,
  monitorParams: state => state.token,
  tunnels: state => state.tunnels,
  sections: state => state.sections,
  wires: state => state.wires,
  monitorDevices: state => state.monitorDevices,
  cameras: state => state.cameras
}

const mutations = {
  editMonitorTypes(state, data) {
    state.monitorTypes = data
  },
  editMonitorParams(state) {
    state.monitorParams = data
  },
  editTunnels(state, data) {
    state.tunnels = data
  },
  editSections(state) {
    state.sections = data
  },
  editWires(state, data) {
    state.wires = data
  },
  editMonitorDevices(state) {
    state.monitorDevices = data
  },
  editCameras(state) {
    state.cameras = data
  }
}
export default {
  state,
  getters,
  mutations
}
