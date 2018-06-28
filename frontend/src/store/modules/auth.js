import * as types from '../mutation-types'
const state = {
  user: {
    name:'blq_admin',
    name_cn:'管理员',
  },
  token: null
}
const getters = {
  user: state => state.user,
  token: state => state.token
}

const mutations = {
  [types.LOGIN](state, { cur_user, token }) {
    localStorage.lims_token = token
    localStorage.lims_user = JSON.stringify(cur_user)
    state.token = token
    state.user = cur_user
  },
  [types.LOGOUT](state) {
    localStorage.removeItem('lims_token')
    localStorage.removeItem('lims_user')
    state.token = null
    state.user = null
  }
}
export default {
  state,
  getters,
  mutations
}
