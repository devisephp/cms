<template>
  <div class="text-ptext">
    <div class="bg-lighter text-light p-4 flex justify-between">
      Top Navigation
    </div>

    <div class="flex">
      <ul class="list-reset bg-darker">
        <li v-for="directory in directories">
          {{ directory }}
        </li>
      </ul>
      <ul class="list-reset">
        <li v-for="file in files">
          {{ file }}
        </li>
      </ul>
    </div>
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
      this.fullyLoadDirectory('')
    },
    methods: {
      ...mapActions([
        'setCurrentDirectory',
        'getCurrentFiles',
        'getCurrentDirectories'
      ]),
      fullyLoadDirectory (directory) {
        let self = this
        self.loaded = false

        self.setCurrentDirectory(directory).then(function () {
          self.getCurrentFiles().then(function () {
            self.getCurrentDirectories().then(function () {
              self.loaded = true
            })
          })
        })
      }
    },
    computed: {
      ...mapGetters([
        'files',
        'directories'
      ])
    }
  }
</script>
