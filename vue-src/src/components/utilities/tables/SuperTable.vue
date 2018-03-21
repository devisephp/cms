<template>
  <div>
    <table class="dvs-table">
      <tr>
        <th v-for="(column, key) in columns" v-bind:key="column.key" v-if="showColumn(column)" :class="{'dvs-hidden lg:dvs-table-cell': !column.showMobile}" @click="showControls(column.key)">
          <div class="dvs-flex" v-if="!column.toggleColumns">
            <div> {{ column.label }} </div>

            <column-controls
              v-model="filters"
              :ref="column.key"
              :column="column"
               class="dvs-hidden lg:dvs-block">
            </column-controls>
          </div>
          <div class="flex" v-else>
            <toggle-columns
              v-model="columns"
               class="dvs-hidden lg:dvs-block">
            </toggle-columns>
            {{ column.label }}
          </div>
        </th>
      </tr>
      <tr v-for="(record, rkey) in records" v-bind:key="record.id">
        <template v-for="(column, index) in columns" v-if="showColumn(column)">
          <td :class="{'dvs-hidden lg:dvs-table-cell': !column.showMobile}">
            <cell v-if="column.template" :record="record" :contents="getRecordColumn(record, column.key)"></cell>
            <span v-else>{{ getRecordColumn(record, column.key) }}</span>
          </td>
        </template>
      </tr>
      <tr v-if="!records.length">
        <td class="dvs-text-center" :colspan="columns.length">No Results Found</td>
      </tr>
    </table>

    <pagination v-if="meta" :meta="meta"></pagination>

    <div>
      <button class="dvs-btn" @click="updateValue">Done</button>
      <button class="dvs-btn" @click="cancel">Cancel</button>
    </div>
  </div>
</template>

<script>
  import commonUtils from './../../../vuex/utils/common'

  import ColumnControls from './ColumnControls'
  import ToggleColumns from './ToggleColumns'
  import Pagination from './Pagination'
  import Cell from './Cell'

  import {mapActions} from 'vuex'

  export default {
    name: 'SuperTable',
    data () {
      return {
        theOptions: {
          showLinks: true
        },
        filters: {
          related: {},
          search: {},
          sort: {},
          dates: {},
          page: '1'
        },
        refreshRecords: null,
        records: [],
        meta: {}
      }
    },
    mounted: function () {
      // Merge options
      this.theOptions.showLinks = this.showLinks
      this.requestRefreshRecords()
    },
    methods: {
      ...mapActions('devise', [
        'getModelRecords'
      ]),
      updateValue () {
        let modelQuery = this.value + '&' + commonUtils.buildFilterParams(this.filters)
        this.$emit('input', modelQuery)
        this.$emit('change', modelQuery)
        this.$nextTick(function () {
          this.$emit('done', modelQuery)
        })
      },
      cancel () {
        this.$emit('cancel')
      },
      requestRefreshRecords () {
        let self = this

        clearTimeout(this.refreshRecords)

        this.refreshRecords = setTimeout(function () {
          self.getModelRecords({
            model: self.value,
            filters: self.filters
          }).then(function (response) {
            self.records = response.data
          })
        }, 500)
      },
      showControls (key) {
        if (this.$refs.hasOwnProperty(key) && this.$refs[key][0].show === false) {
          this.$refs[key][0].show = true
        }
      },
      // Checks to see if the key includes a period meaning that its a property of a property
      getRecordColumn (record, key) {
        if (!key.includes('.')) {
          return record[key]
        } else {
          return this.getRecordColumnTraversal(record, key)
        }
      },
      // Get in there and get the property at the bottom of the stack
      getRecordColumnTraversal (record, key) {
        let parts = key.split('.[].')

        for (let i = 0; i < parts.length; i++) {
          var part = parts[i]

          // If it's the array part
          if (i % 2 === 1) {
            record = this.getFormattedStringFromArray(record, part)
          } else {
            record = [record].concat(part.split('.')).reduce(function (a, b) {
              return a[b]
            })
          }
        }

        return record
      },
      getFormattedStringFromArray (record, part) {
        var finalString = ''

        for (let i = 0; i < record.length; i++) {
          if (i > 0) {
            finalString += ', '
          }

          finalString += record[i][part]
        }

        return finalString
      },
      showColumn (column) {
        return column.show === true || typeof column.show === 'undefined'
      }
    },
    watch: {
      filters () {
        this.requestRefreshRecords()
      }
    },
    props: {
      value: {
        type: String
      },
      columns: {
        type: Array,
        required: true
      },
      showLinks: {
        type: Boolean
      }
    },
    components: {
      'column-controls': ColumnControls,
      'toggle-columns': ToggleColumns,
      'pagination': Pagination,
      'cell': Cell
    }
  }
</script>
