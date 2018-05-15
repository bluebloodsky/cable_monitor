import Vue from 'vue'
import Router from 'vue-router'
import PageHome from '../pages/PageHome'
import PageNotFind from '../pages/PageNotFind'
import PageDeskTop from '../pages/PageDeskTop'
import PageMonitorData from '../pages/PageMonitorData'
import PageConfig from '../pages/PageConfig'
Vue.use(Router)

const router = new Router({
  routes: [{
    path: '/',
    redirect: '/home',
  }, {
    path: '/home',
    name: 'home',
    redirect: '/home/desktop',
    component: PageHome,
    children: [{
      path: 'not-find',
      component: PageNotFind
    }, {
      path: 'desktop',
      component: PageDeskTop
    }, {
      path: 'data',
      component: PageMonitorData
    }, {
      path: 'config',
      component: PageConfig
    }]
  }]
})

router.beforeEach((to, from, next) => {
  if (to.matched.length == 0) {
    next({
      path: '/home/not-find'
    })
  } else {

    next()
  }
})

export default router
