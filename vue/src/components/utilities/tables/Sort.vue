<template>
  <div class="dvs-flex dvs-px-4 dvs-py-8">
    <fieldset class="dvs-mr-4 dvs-flex">
      <div class="dvs-flex dvs-items-center">
        <label class="dvs-pr-2">Ascending</label>
        <input type="radio" v-model="direction" value="asc" @change="update"
               @click="checkRemove($event.target.value)">
      </div>
    </fieldset>
    <fieldset class="dvs-ml-4">
      <div class="dvs-flex dvs-items-center">
        <label class="dvs-pr-2">Descending</label>
        <input type="radio" v-model="direction" value="desc" @change="update"
               @click="checkRemove($event.target.value)">
      </div>
    </fieldset>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    name: 'SuperTableSort',
    data () {
      return {
        direction: null
      }
    },
    mounted () {
      let sort = this.filters[this.type].sort
      if (sort.hasOwnProperty(this.column)) {
        this.direction = sort[this.column]
      }
    },
    methods: {
      ...mapActions([
        'updateFilters'
      ]),
      clear () {
        this.removeFilter()
      },
      update () {
        let filterPayload = {}

        filterPayload[this.type] = this.filters[this.type]
        filterPayload[this.type].sort[this.column] = this.direction

        this.updateFilters(filterPayload)
      },
      checkRemove (value) {
        if (this.direction === value) {
          this.removeFilter()
        }
      },
      removeFilter () {
        this.direction = null
        let filterPayload = {}

        filterPayload[this.type] = this.filters[this.type]
        delete (filterPayload[this.type].sort[this.column])

        this.updateFilters(filterPayload)
      }
    },
    computed: {
      ...mapGetters([
        'filters'
      ])
    },
    props: ['type', 'column']
  }
</script>
