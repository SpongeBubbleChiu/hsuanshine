import Vue from 'vue'
import Router from 'vue-router'

import Home from 'components/route/HelloWorld.vue'
import Router404 from 'components/route/router-404.vue'

Vue.use(Router)
export default new Router
  mode: 'history'
  routes: [
    {
      path: "*"
      name: "404"
      component: Router404
    }
    {
      path: '/'
      name: 'home'
      component: Home
    }
  ]
