import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'
import actions from './actions'
import getters from './getters'

Vue.use(Vuex)

// root state object.
// each Vuex instance is just a single state tree.
const state = {
  // Application State
  api: {
    baseUrl: '/api/devise/'
  },
  // Media Manager
  currentDirectory: '.',
  files: [],
  directories: [],
  languages: {
    data: []
  },
  meta: {
    data: []
  },
  models: {
    data: []
  },
  modelSettings: {},
  pages: {
    data: []
  },
  sites: {
    data: []
  },
  slices: {
    data: []
  },
  templates: {
    data: []
  },
  users: {
    data: []
  }
}

// A Vuex instance is created by combining the state, the actions,
// and the mutations. Because the actions and mutations are just
// functions that do not depend on the instance itself, they can
// be easily tested or even hot-reloaded (see counter-hot example).
//
// You can also provide middlewares, which is just an array of
// objects containing some hooks to be called at initialization
// and after each mutation.
export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
