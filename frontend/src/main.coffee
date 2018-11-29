import Vue from 'vue'
import routers from 'routers.coffee'
import App from 'App.vue'
(() ->
  window.self.$ = $
  window.rootComponent = new Vue
    el:    '#app'
    router: routers
    render: (h) ->
      h App
)()