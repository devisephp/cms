<template>
  <div class="flex px-4 py-8 flex flex-col max-h-200  overflow-y-scroll">
    <div>
      <fieldset>
        <input type="text" v-model="relatedFilter" placeholder="Filter" class="fancy w-full mb-4">
      </fieldset>
    </div>
    <div v-for="(option, key) in filteredOptions">
      <fieldset class="mr-4 flex mb-2">
        <div class="flex items-center">
          <input type="checkbox" v-model="selected" class="fancy" :value="option[options.key]" @change="update">
          <label class="pl-2">{{ option[options.label] }}</label>
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
