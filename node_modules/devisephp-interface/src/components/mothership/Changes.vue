<template>
    <div class="dvs-p-8">
        <h3 class="mb-6">Mothership</h3>

        <div id="devise-admin-content">
            It's time to make some changes
        </div>
    </div>
</template>

<script>

  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: 'MothershipChanges',
    data() {
      return {
        analytics: null,
        minimized: false,
        localValue: null
      }
    },
    mounted() {
      this.retrieveChanges()
    },
    methods: {
      ...mapActions('devise', [
        'getPendingChanges'
      ]),
      retrieveChanges() {
        let self = this
        this.getPendingChanges().then(function (response) {
          self.$set(self, 'localValue', response.data)
        })
      },
    },
    computed: {
      ...mapGetters('devise', [
        'changes'
      ])
    }
  }
</script>