<template>
  <div class="dvs-flex dvs-px-4 dvs-py-8">
    <fieldset class="dvs-w-full">
      <label class="dvs-pb-2">Date Range</label>
      <flat-pickr
        v-model="after"
        :config="afterConfig"
        class="dvs-w-full dvs-mb-4"
        @on-change="onAfterChange"
        placeholder="After"></flat-pickr>
      <flat-pickr
        v-model="before"
        :config="beforeConfig"
        class="fancy w-full"
        @on-change="onBeforeChange"
        placeholder="Before"></flat-pickr>
    </fieldset>
  </div>
</template>

<script>
import flatPickr from 'vue-flatpickr-component'
import dayjs from 'dayjs'

import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'SuperTableDates',
  data () {
    return {
      afterConfig: {
        enableTime: false,
        dateFormat: 'F d Y'
      },
      beforeConfig: {
        enableTime: false,
        dateFormat: 'F d Y'
      },
      after: '',
      before: '',
      dates: {
        after: '',
        before: ''
      },
      searchMethod: null,
      preventUpdate: false
    }
  },
  created () {
    let dates = this.filters[this.type].dates
    if (dates.hasOwnProperty(this.column)) {
      let range = dates[this.column]
      if (range.hasOwnProperty('after') && range.after !== '') {
        this.after = dayjs(range.after, 'YYYY-MM-DD').format('MMMM D YYYY')
        this.dates.after = range.after
      }
      if (range.hasOwnProperty('before') && range.before !== '') {
        this.before = dayjs(range.before, 'YYYY-MM-DD').format('MMMM D YYYY')
        this.dates.before = range.before
      }
    }
  },
  methods: {
    ...mapActions([
      'updateFilters'
    ]),
    onAfterChange (selectedDates, dateStr, instance) {
      this.dates.after = (dateStr) ? dayjs(dateStr, 'MMMM D YYYY').format('YYYY-MM-DD') : ''
      this.update()
    },
    onBeforeChange (selectedDates, dateStr, instance) {
      this.dates.before = (dateStr) ? dayjs(dateStr, 'MMMM D YYYY').format('YYYY-MM-DD') : ''
      this.update()
    },
    clear () {
      this.after = ''
      this.before = ''
    },
    update () {
      let filterPayload = {}

      filterPayload[this.type] = this.filters[this.type]
      filterPayload[this.type].dates[this.column] = this.dates
      filterPayload[this.type].page = 1

      this.updateFilters(filterPayload)
    }
  },
  computed: {
    ...mapGetters([
      'filters'
    ])
  },
  components: {
    flatPickr
  },
  props: ['type', 'column']
}
</script>
