// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import axios from './http'
import App from './App'
import router from './router'
import store from './store'
import Date from './shared/extend'

Vue.config.productionTip = true
/* eslint-disable no-new */
Vue.prototype.cfgInfo = cfgInfo
Vue.prototype.axios = axios
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
