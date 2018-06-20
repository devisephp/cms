<template>
  <div class="dvs-flex dvs-px-4 dvs-py-8 dvs-flex dvs-flex-col dvs-max-h-200  dvs-overflow-y-scroll">
    <div>
      <fieldset>
        <input type="text" v-model="relatedFilter" placeholder="Filter" class="dvs-w-full dvs-mb-4">
      </fieldset>
    </div>
    <div v-for="(option, key) in filteredOptions">
      <fieldset class="dvs-mr-4 dvs-flex mb-2">
        <div class="dvs-flex dvs-items-center">
          <input type="checkbox" v-model="selected" :value="option[options.key]" @change="update">
          <label class="dvs-pl-2">{{ option[options.label] }}</label>
        </div>
      </fieldset>
    </div>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: 'SuperTableRelated',
    data: function () {
      return {
        selected: [],
        relatedFilter: ''
      }
    },
    mounted () {
      let related = this.filters[this.type].related
      if (related.hasOwnProperty(this.options.field)) {
        this.selected = this.filters[this.type].related[this.options.field]
      }
    },
    methods: {
      ...mapActions([
        'updateFilters'
      ]),
      clear () {
        this.selected = []
        this.relatedFilter = ''
        this.update()
      },
      update () {
        let filterPayload = this.filters

        if (this.selected.length > 0) {
          filterPayload[this.type].related[this.options.field] = this.selected
          filterPayload[this.type].page = 1
        } else {
          delete (filterPayload[this.type].related[this.options.field])
        }

        this.updateFilters(filterPayload)
      }
    },
    computed: {
      filteredOptions () {
        var filteredRelated = []
        let self = this

        if (typeof self.relatedFilter !== 'undefined' && self.relatedFilter !== '') {
          // TODO - REDO THIS SO WE DON'T HAVE TO USE UNDERSCORE
          // filteredRelated = _.pick(self[self.options.data], function (value, key) {
          //   return value.name.toLowerCase().includes(self.relatedFilter.toLowerCase())
          // })
        } else {
          return this[this.options.data]
        }

        return filteredRelated
      },
      ...mapGetters([
        'filters',
        'categoriesList'
      ])
    },
    props: ['options', 'type']
  }
</script>
