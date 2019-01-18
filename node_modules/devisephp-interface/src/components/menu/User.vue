<template>
  <panel id="devise-menu-current-user" class="dvs-z-40 dvs-p-8" :panel-style="theme.panel">
    <div class="dvs-flex dvs-justify-between dvs-items-center dvs-p-8">
      <div>
        <router-link
          :to="{ name: 'devise-users-edit', params: { userId: user.id }}"
          class="dvs-mr-4"
        >
          <strong class="dvs-text-sm" :style="`color: ${theme.panel.color};`">{{user.name}}</strong>
        </router-link>
        <br>
        <span class="dvs-text-xs" :style="`color: ${theme.panel.color};`">{{user.email}}</span>
      </div>
      <div>
        <a
          href="/logout}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
          <power-icon class="mr-1" w="20" h="20" :style="`color: ${theme.panelIcons.color};`"/>
        </a>

        <form id="logout-form" action="/logout" method="POST" style="display: none;">
          <input type="hidden" name="_token" :value="csrf_field">
        </form>
      </div>
    </div>
  </panel>
</template>

<script>
import { mapGetters } from 'vuex';

import Panel from './../utilities/Panel';

export default {
  name: 'DeviseUser',
  data() {
    return {};
  },
  computed: {
    user() {
      return deviseSettings.$user;
    },
    csrf_field() {
      return window.axios.defaults.headers.common['X-CSRF-TOKEN'];
    }
  },
  components: {
    Panel,
    PowerIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-power.vue')
  }
};
</script>
