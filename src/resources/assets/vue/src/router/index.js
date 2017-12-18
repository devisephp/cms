import Vue from 'vue'
import Router from 'vue-router'
import MediaManager from '@/components/MediaManager'
import Meta from '@/components/Meta'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/media',
      name: 'MediaManager',
      component: MediaManager
    },
    {
      path: '/meta',
      name: 'Meta',
      component: Meta
    }
  ]
})
