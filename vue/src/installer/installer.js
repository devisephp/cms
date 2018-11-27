let Vue = require("vue");

import store from "./vuex/store";

import Installer from "./components/Installer";
Vue.component("devise-installer", Installer);

import Item from "./components/Item";
Vue.component("devise-installer-item", Item);

import CheckmarkCircleIcon from "vue-ionicons/dist/ios-checkmark-circle-outline.vue";
Vue.component("checkmark-icon", CheckmarkCircleIcon);

import CloseCircleIcon from "vue-ionicons/dist/ios-close-circle-outline.vue";
Vue.component("close-circle-icon", CloseCircleIcon);

import AlertIcon from "vue-ionicons/dist/ios-alert.vue";
Vue.component("alert-icon", AlertIcon);

new Vue({
  el: "#installer-app",
  store: store
});
