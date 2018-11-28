import Vue from 'vue';
import Vuex from 'vuex';
import mutations from './mutations';
import actions from './actions';
import getters from './getters';

Vue.use(Vuex);

// root state object.
// each Vuex instance is just a single state tree.
const state = {
  // Application State
  api: {
    baseUrl: '/api/devise/'
  },
  checklist: {
    database: true,
    migrations: false,
    auth: true,
    user: false,
    site: false,
    page: false,
    image_library: false,
    image_optimization: {
      jpegoptim: false,
      optipng: false,
      pngquant: false,
      svgo: false,
      gifsicle: false
    }
  }
};

export default {
  state,
  mutations,
  actions,
  getters
};
