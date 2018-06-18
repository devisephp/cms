<template>
  <div class="dvs-absolute dvs-pin-b dvs-pin-l dvs-pin-r dvs-p-4 dvs-m-8 dvs-rounded-lg dvs-z-20" 
  id="devise-menu-current-user"
  style="max-width:300px;"
  :style="`
    background: ${theme.userBackground.color};
    color: ${theme.userText.color};
    box-shadow: -4px -4px ${theme.userShadowSize.text} ${theme.userShadowColor.color};
  `">
    <div class="dvs-flex dvs-justify-between dvs-p-4 dvs-items-center">
      <div>
        <router-link :to="{ name: 'devise-users-edit', params: { userId: user.id }}" class="dvs-mr-4">
          <strong :style="`color: ${theme.userText.color};`">{{user.name}}</strong>
        </router-link><br>
        <span :style="`color: ${theme.userText.color};`">{{user.email}}</span>
      </div>
      <div>
        <a href="/logout}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <power-icon class="mr-1" w="30" h="30" :style="`color: ${theme.userText.color};`" />
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
