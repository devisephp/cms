<template>
  <div>
    <transition name="dvs-fade-delayed">
      <div class="dvs-alert-message dvs-error" :style="infoBlockTheme" v-show="messageErrors.length > 0">
        <div @click="closeErrors()" class="dvs-absolute dvs-pin-t dvs-pin-r dvs-mr-4 dvs-mt-4">
          <close-icon class="dvs-cursor-pointer" w="20" h="20" />
        </div>
        <ul>
          <transition-group name="list" tag="div">
            <li v-for="(error, key) in messageErrors" :key="key" :style="`border-bottom-color:${infoBlockTheme.color}`">
              <h6 :style="`color:${infoBlockTheme.color}`">{{ error.title }}</h6>
              <p :style="`color:${infoBlockTheme.color}`">{{ error.message }}</p>
              <p :style="`color:${infoBlockTheme.color}`" class="dvs-text-sm" v-if="error.code">Error Code: {{ error.code }}</p>
            </li>
          </transition-group>
        </ul>
      </div>
    </transition>
    <transition name="dvs-fade-delayed">
      <div class="dvs-alert-message" :style="infoBlockTheme" v-show="messages.length > 0">
        <i @click="closeMessages()" class="cursor-pointer ion-icon ion-android-close"></i>
        <ul>
          <transition-group name="list" tag="div">
            <li v-for="(message, key) in messages" :key="key" :style="`border-bottom-color:${infoBlockTheme.color}`">
              <h6 class="dvs-text-base" :style="`color:${infoBlockTheme.color}`">{{ message.title }}</h6>
              <p :style="`color:${infoBlockTheme.color}`">{{ message.message }}</p>
            </li>
          </transition-group>
        </ul>
      </div>
    </transition>
  </div>
</template>


<script>
import CloseIcon from 'vue-ionicons/dist/ios-close.vue'
import Strings from '../../mixins/Strings'

export default {
  data () {
    return {
      title: null,
      messages: [],
      messageErrors: []
    }
  },
  mounted () {
    let self = this
    deviseSettings.$bus.$on('showError', function (error) {
      self.addError(error)
    })

    deviseSettings.$bus.$on('showMessage', function (payload) {
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
        typeof error.response !== 'undefined' &&
        typeof error.response.data !== 'undefined' &&
        error.response.data !== null &&
        error.response.data.message !== null
      ) {
        self.appendError({
          code: error.response.status,
          title: error.response.data.exception,
          message: error.response.data.message
        })
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
      let existingError = this.messageErrors.find(error => error.message === payload.message)

      if (!existingError) {
        let error = {
          code: payload.code,
          title: payload.title,
          message: payload.message
        }
        this.messageErrors.unshift(error)

        window._.debounce(function () {
          self.messageErrors.pop()
        }, 5000)()
      }
    },
    closeErrors () {
      this.messageErrors.splice(0)
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
  mixins: [Strings],
  components: {
    CloseIcon
  }
}
</script>
