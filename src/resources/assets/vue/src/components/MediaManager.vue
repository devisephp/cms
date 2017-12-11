<template>
  <div>
    Hey there
    {{ loaded }}
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    data () {
      return {
        loaded: false
      }
    },
    mounted () {
      let self = this

      this.setCurrentDirectory('').then(function () {
        self.getCurrentFiles().then(function () {
          self.loaded = true
        })
      })
    },
    methods: {
      ...mapActions([
        'setCurrentDirectory',
        'getCurrentFiles'
      ])
    },
    computed: {
      ...mapGetters([
        'files'
      ])
    }
  }
</script>
