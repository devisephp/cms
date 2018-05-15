<template>
  <div class="dvs-absolute dvs-pin-b dvs-pin-l dvs-pin-r dvs-p-8" id="devise-menu-current-user">
    <div class="dvs-flex dvs-justify-between dvs-p-4 dvs-items-center">
      <div>
        <router-link :to="{ name: 'devise-users-edit', params: { userId: user.id }}" class="dvs-mr-4">
          <strong>{{user.name}}</strong>
        </router-link><br>
        <span class="dvs-text-grey">{{user.email}}</span>
      </div>
      <div>
        <a href="/logout}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="ion-power text-xl mr-1"></i>
        </a>

        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" :value="csrf_field">
        </form>
      </div>
    </div>
  </div>
</template>

<script>
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
  }
}
</script>
