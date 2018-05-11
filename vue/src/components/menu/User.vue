<template>
  <div class="dvs-absolute dvs-pin-b dvs-pin-l dvs-pin-r">
    <div class="dvs-bg-grey-lighter dvs-rounded-sm dvs-m-8 dvs-mb-0">
      <div class="dvs-flex dvs-justify-between dvs-p-4 dvs-items-center">
        <div>
          <strong>{{user.name}}</strong><br>
          <span class="dvs-text-grey">{{user.email}}</span>
        </div>
        <router-link :to="{ name: 'devise-users-edit', params: { userId: user.id }}" class="dvs-mr-4">
          <i class="ion-gear-a text-2xl"></i>
        </router-link>
      </div>
      <div class="dvs-flex mt-2 dvs-items-center dvs-bg-grey-light dvs-p-4">
        <a href="/logout}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="ion-power text-xl mr-1"></i>Logout
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
      return window.user
    },
    csrf_field () {
      return window.axios.defaults.headers.common['X-CSRF-TOKEN']
    }
  }
}
</script>
