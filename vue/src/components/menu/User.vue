<template>
  <div class="dvs-bg-grey-lighter dvs-flex dvs-border-b dvs-border-lighter" id="devise-user">
    <div class="dvs-border-r dvs-border-grey dvs-flex">
      <div class="dvs-min-w-1/4 dvs-border-r dvs-border-grey dvs-flex dvs-justify-between">
        <div class="dvs-flex dvs-justify-start dvs-items-center pr-4 dvs-w-3/5 dvs-flex-wrap dvs-p-4 dvs-pl-8">
          <div class="dvs-py-2 dvs-pr-4">
            {{ user.name }}<br>
            <span class="dvs-text-grey">gary@lbm.co</span>
          </div>
        </div>
        <div class="dvs-w-1/5 dvs-flex dvs-justify-center dvs-items-center">
          <!-- <i class="ion-gear-a text-3xl"></i> -->
        </div>
      </div>
      <div class="dvs-flex dvs-flex-grow dvs-items-center dvs-border-l dvs-border-white dvs-w-1/5 dvs-text-center">
        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="ion-power text-2xl p-4"></i>
        </a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
          <input type="hidden" name="_token" :value="csrf">
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
      csrf: null,
      user: {
        id: null,
        email: null,
        name: null
      }
    }
  },
  mounted () {
    this.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    if (!this.csrf) {
      console.warn('Please ensure <meta name="csrf-token" content="{{ csrf_token() }}"> is present in the <head> of your layout')
    }
    this.user = Object.assign({}, window.user)
  }
}
</script>
