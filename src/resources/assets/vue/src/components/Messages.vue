<style lang="scss" scoped>
  @import "./../sass/app.scss";
</style>

<template>
  <div>
    <transition name="fade">
      <div class="alert-message error" v-show="errors.length > 0">
        <i @click="closeErrors()" class="cursor-pointer ion-icon ion-android-close float-right"></i>
        <ul>
          <transition-group name="list" tag="div">
            <li v-for="error in errors" :key="error.message">
              <h6>{{ error.title }}</h6>
              <p>{{ error.message }}</p>
              <p class="text-xs" v-if="error.code">{{ error.code }}</p>
            </li>
          </transition-group>
        </ul>
      </div>
    </transition>
    <transition name="fade">
      <div class="alert-message" v-show="messages.length > 0">
        <i @click="closeMessages()" class="cursor-pointer ion-icon ion-android-close float-right"></i>
        <ul>
          <transition-group name="list" tag="div">
            <li v-for="message in messages" :key="message.message">
              <h6>{{ message.title }}</h6>
              <p>{{ message.message }}</p>
            </li>
          </transition-group>
        </ul>
      </div>
    </transition>
  </div>
</template>


<script>
import eventbus from './../event-bus/event-bus'

export default {
  data () {
    return {
      errors: [],
      messages: []
    }
  },
  mounted () {
    let self = this
    eventbus.$on('showError', function (error) {
      self.addError(error)
    })

    eventbus.$on('showMessage', function (payload) {
      self.addMessage(payload)
    })
  },
  methods: {
    addError (error) {
      console.log(typeof error, typeof error.title, typeof error.message)
      let self = this
      // Error came from axios most likely
      if (
        typeof error.response !== 'undefined' &&
        typeof error.response.data !== 'undefined' &&
        typeof error.response.data.errors !== 'undefined' &&
        error.response.data.errors.length > 0
      ) {
        for (var i = 0; i < error.response.data.errors.length; i++) {
          let e = error.response.data.errors[i]
          self.appendError({
            code: e.code + '-' + e.status,
            title: e.title,
            message: e.details
          })
        }
      } else if (
        typeof error.data !== 'undefined' &&
        error.data !== null
      ) {
        self.appendError({
          code: error.status,
          title: error.data.error,
          message: error.data.message
        })
      } else if (
        typeof error === 'object' &&
        typeof error.title !== 'undefined' &&
        typeof error.message !== 'undefined'
      ) {
        console.log('hal;sdkjf;lasdjflajsdf;lja')
        self.appendError({
          code: '',
          title: error.title,
          message: error.message
        })
      } else if (typeof error === 'string') {
        self.appendError({
          code: '',
          title: 'Uh-Oh!',
          message: error
        })
      } else {
        self.appendError({
          code: error.status,
          title: 'Error',
          message: 'There was an issue with your request or please check your Internet connection'
        })
      }
    },
    appendError (payload) {
      let self = this
      let error = {
        code: payload.code,
        title: payload.title,
        message: payload.message
      }
      this.errors.unshift(error)

      window._.debounce(function () {
        self.errors.pop()
      }, 5000)()
    },
    closeErrors () {
      this.errors.splice(0)
    },
    addMessage (payload) {
      let self = this
      let message = {
        title: payload.title,
        message: payload.message
      }
      this.messages.unshift(message)

      window._.debounce(function () {
        self.messages.pop()
      }, 5000)()
    },
    closeMessages () {
      this.messages.splice(0)
    }
  }
}
</script>
