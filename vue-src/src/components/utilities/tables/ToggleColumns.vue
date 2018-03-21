<template>
  <div class="mr-4 relative">
    <i class="ion-ios-toggle-outline cursor-pointer" @click="show = true"></i>
    <div v-show="show" class="absolute pin-t pin-r mt-1 bg-background-lighter min-w-250 z-40 shadow-lg border-t-2 border-background-lighter">
      <div class="bg-background-darker pt-4 pb-2 px-4 ">
        Toggle Columns <i class="ion-close-round cursor-pointer float-right" @click="show = false"></i>
      </div>
      <div class="px-4">
        <div class="flex px-4 py-8 flex flex-col max-h-200 overflow-y-scroll">
          <div>
            <fieldset class="mr-4 flex mb-2" v-for="(column, index) in columns" :key="column.key" v-if="!column.toggleColumns">
              <div class="flex items-center">
                <input type="checkbox" v-model="column.show" class="fancy" @change="update">
                <label class="pl-2">{{ column.label }}</label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {mapGetters} from 'vuex'

export default {
  name: 'ToggleColumns',
  data () {
    return {
      show: false,
      columns: []
    }
  },
  mounted () {
    this.columns = this.value

    for (let i = 0; i < this.columns.length; i++) {
      if (typeof this.columns[i].show === 'undefined') {
        this.$set(this.columns[i], 'show', true)
      }
    }
  },
  methods: {
    update () {
      // TODO - This is current an error and needs to be ported for Devise
      // local.set(this.type + '-columns-' + this.currentTeam.id, this.columns)

      this.$emit('input', this.columns)
    }
  },
  computed: {
    ...mapGetters([
      'currentTeam'
    ])
  },
  props: {
    value: {
      type: Array,
      required: true
    },
    type: {
      type: String,
      required: true
    }
  }
}
</script>
