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
    database: false,
    migrations: false,
    auth: false,
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
  },
  languages: {
    data: []
  }
};

// A Vuex instance is created by combining the state, the actions,
// and the mutations. Because the actions and mutations are just
// functions that do not depend on the instance itself, they can
// be easily tested or even hot-reloaded (see counter-hot example).
//
// You can also provide middlewares, which is just an array of
// objects containing some hooks to be called at initialization
// and after each mutation.
export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters
});
