<template>
  <div>
    <transition name="fade">
      <div class="alert-message error" v-show="errors.length > 0">
        <h5>{{mainTitle}} <i @click="closeErrors()" class="cursor-pointer ion-icon ion-android-close"></i></h5>
        <ul>
          <transition-group name="list" tag="div">
            <li v-for="error in errors" :key="randomString(5)">
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
        <h5>Hey There! <i @click="closeMessages()" class="cursor-pointer ion-icon ion-android-close"></i></h5>
        <ul>
          <transition-group name="list" tag="div">
            <li v-for="message in messages" :key="randomString(5)">
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
import Strings from '../../mixins/Strings'

export default {
  data () {
    return {
      title: null,
      errors: [],
      messages: []
    }
  },
  mounted () {
    let self = this
    window.bus.$on('showError', function (error) {
      self.addError(error)
    })

    window.bus.$on('showMessage', function (payload) {
      self.addMessage(payload)
    })
  },
  methods: {
    addError (error) {
      let self = this
      // Error came from axios most likely
      if (
        typeof error.response !== 'undefined' &&
        typeof error.response.data !== 'undefined' &&
        typeof error.response.data.errors !== 'undefined'
      ) {
        this.title = error.response.data.message
        for (var property in error.response.data.errors) {
          if (error.response.data.errors.hasOwnProperty(property)) {
            let e = error.response.data.errors[property]
            self.appendError({
              code: error.response.status,
              title: error.response.statusText,
              message: e[0]
            })
          }
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
      } else if (typeof error === 'string') {
        self.appendError({
          code: '',
          title: 'Uh-Oh!',
          message: error
        })
      } else {
        self.appendError({
          code: error.status,
          title: 'Unable to reach server',
          message: 'Please check your internet connection'
        })
      }
    },
    appendError (payload) {
      let self = this
      let existingError = this.errors.find(error => error.message === payload.message)

      if (!existingError) {
        let error = {
          code: payload.code,
          title: payload.title,
          message: payload.message
        }
        this.errors.unshift(error)

        window._.debounce(function () {
          self.errors.pop()
        }, 5000)()
      }
    },
    closeErrors () {
      this.errors.splice(0)
    },
    addMessage (payload) {
      let self = this
      let existingMessage = this.messages.find(message => message.message === payload.message)

      if (!existingMessage) {
        let message = {
          title: payload.title,
          message: payload.message
        }
        this.messages.unshift(message)

        window._.debounce(function () {
          self.messages.pop()
        }, 5000)()
      }
    },
    closeMessages () {
      this.messages.splice(0)
    }
  },
  computed: {
    mainTitle () {
      if (this.title === null) {
        return 'There was a Problem'
      } else {
        return this.title
      }
    }
  },
  mixins: [Strings]
}
</script>
