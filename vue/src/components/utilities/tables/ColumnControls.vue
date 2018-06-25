<template>
  <div class="dvs-ml-4" v-if="shouldDisplayControls">
    <div @click="show = true" class="dvs-cursor-pointer">
      <settings-icon />
    </div>
    <div v-show="show">
      <div class="dvs-blocker dvs-z-20" @click="hide"></div>
      <div v-show="show" class="dvs-absolute dvs-pin-b dvs-pin-l dvs-mb-1 dvs-bg-white dvs-min-w-250 dvs-z-40 dvs-shadow-lg dvs-border-t-2 dvs-border-grey-lighter">
        <div class="bg-background-darker pt-4 pb-2 px-4 flex justify-between">
          {{ this.column.label }}
          <div>
            <button class="dvs-pr-4 dvs-uppercase dvs-text-xs dvs-outline-none" @click="clearAll()">Clear</button>|
            <div @click="hide">
              <arrow-round-back-icon class="dvs-pl-4 dvs-cursor-pointer dvs-float-right" />
            </div>
          </div>
        </div>
        <div class="dvs-px-4 dvs-column-control-modules">
          <search ref="search" v-model="localFilters" @change="updateValue" v-if="typeof column.search !== 'undefined'" :column="column.search" :options="column.options"></search>
          <!-- <related ref="related" v-if="typeof column.related !== 'undefined'" :options="column.related"></related>
          <dates ref="dates" v-if="typeof column.dates !== 'undefined'" :column="column.dates"></dates>

          <sort ref="sort" v-if="typeof column.sort !== 'undefined'" :column="column.sort"></sort> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Search from './Search'
import Sort from './Sort'
import Related from './Related'
import Dates from './Dates'

import SettingsIcon from 'vue-ionicons/dist/ios-settings.vue'
import ArrowRoundBackIcon from 'vue-ionicons/dist/ios-arrow-round-back.vue'

export default {
  name: 'ColumnControls',
  data () {
    return {
      show: false,
      localFilters: null
    }
  },
  mounted () {
    this.localFilters = Object.assign({}, this.localFilters, this.value)
  },
  methods: {
    updateValue () {
      this.$emit('input', this.localFilters)
      this.$emit('change', this.localFilters)
    },
    clearAll () {
      this.localFilters = {
        related: {},
        search: {},
        sort: {},
        dates: {},
        page: '1'
      }
      this.updateValue()
    },
    hide () {
      let self = this
      // hacky need to find a better way to have the column clickable
      this.$nextTick(function () {
        self.show = false
      })
    }
  },
  computed: {
    shouldDisplayControls () {
      return typeof this.column.sort !== 'undefined' ||
      typeof this.column.search !== 'undefined' ||
      typeof this.column.related !== 'undefined' ||
      typeof this.column.dates !== 'undefined'
    }
  },
  props: {
    column: {
      type: Object,
      required: true
    },
    value: {}
  },
  components: {
    ArrowRoundBackIcon,
    Dates,
    SettingsIcon,
    Related,
    Search,
    Sort
  }
}
</script>
