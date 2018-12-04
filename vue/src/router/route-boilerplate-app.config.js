import Vue from 'vue';
import VueRouter from 'vue-router';

var routes = [];

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'abstract',
  history: true,
  transitionOnLoad: true,
  routes: routes
});

router.beforeEach((to, from, next) => {
  // Set the page title
  if (typeof to.meta.title !== 'undefined') {
    document.title = to.meta.title;
  } else {
    document.title = 'Welcome to Devise';
  }
  next();
});

export default router;
