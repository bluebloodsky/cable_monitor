import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import devCfg from './modules/devCfg'
Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    devCfg
  }
})
