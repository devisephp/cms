import Vue from 'vue'
import Router from 'vue-router'
import MediaManager from '@/components/MediaManager'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'MediaManager',
      component: MediaManager
    }
  ]
})
