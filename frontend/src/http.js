import axios from 'axios'
import store from './store'

console.log(store)
// axios 配置
axios.defaults.timeout = 15000

if (process.env.NODE_ENV == 'development') {
  axios.defaults.baseURL= cfgInfo['development'].baseURL
} else {
  axios.defaults.baseURL = cfgInfo['production'].baseURL
}
axios.defaults.withCredentials = true
// http request 拦截器
axios.interceptors.request.use(
  config => {
    if (store.state.token) {
      config.headers.Authorization = `token ${store.state.token}`
    }
    return config
  },
  err => {
    return Promise.reject(err)
  })

// http response 拦截器
axios.interceptors.response.use(
  response => {
    return response
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        case 401:
          // 401 清除token信息并跳转到登录页面
          store.commit('logout')
          break
      }      
      return Promise.reject(error.response.data) //后台回复错误
    }
    return Promise.reject(error)
  });

export default axios;
