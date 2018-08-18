<template>
  <div 
    class="dvs-fixed dvs-p-6 dvs-z-40 dvs-rounded dvs-shadow-lg dvs-m-8" 
    style="background:rgba(0,0,0,0.7)"
    id="devise-menu-current-user">
    <div class="dvs-flex dvs-justify-between dvs-items-center">
      <div>
        <router-link :to="{ name: 'devise-users-edit', params: { userId: user.id }}" class="dvs-mr-4">
          <strong class="dvs-text-sm" :style="`color: ${theme.adminText.color};`">{{user.name}}</strong>
        </router-link><br>
        <span class="dvs-text-xs" :style="`color: ${theme.adminText.color};`">{{user.email}}</span>
      </div>
      <div>
        <a href="/logout}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <power-icon class="mr-1" w="20" h="20" :style="`color: ${theme.adminText.color};`" />
        </a>

        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="csrf_field">
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import PowerIcon from 'vue-ionicons/dist/ios-power.vue'

export default {
  name: 'DeviseUser',
  data () {
    return {
    }
  },
  computed: {
    user () {
      return deviseSettings.$user
    },
    csrf_field () {
      return window.axios.defaults.headers.common['X-CSRF-TOKEN']
    }
  },
  components: {
    PowerIcon
  }
}
</script>
