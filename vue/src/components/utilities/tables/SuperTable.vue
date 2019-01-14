<template>
  <div>
    <table class="dvs-table dvs-mb-8">
      <tr>
        <th
          v-for="(column, key) in columns"
          :key="key"
          v-if="showColumn(column)"
          :class="{'dvs-hidden md:dvs-table-cell': column.hideMobile}"
          @click="showControls(column.key)"
        >
          <div class="dvs-flex" v-if="!column.toggleColumns">
            <div>{{ column.label }}</div>
            <column-controls v-model="filters" :ref="column.key" :column="column"></column-controls>
          </div>
          <div class="flex" v-else>
            <toggle-columns v-model="columns"></toggle-columns>
            {{ column.label }}
          </div>
        </th>
      </tr>
      <tr v-for="(record, rkey) in theRecords" :key="rkey">
        <template v-for="(column, index) in columns" v-if="showColumn(column)">
          <td :key="index" :class="{'dvs-hidden lg:dvs-table-cell': column.hideMobile}">
            <cell
              v-if="column.template"
              :record="record"
              :contents="getRecordColumn(record, column.key)"
            ></cell>
            <span v-else>{{ getRecordColumn(record, column.key) }}</span>
          </td>
        </template>
      </tr>
      <tr v-if="!theRecords.length">
        <td class="dvs-text-center" :colspan="columns.length">No Results Found</td>
      </tr>
    </table>

    <pagination
      class="dvs-mb-8"
      v-if="records.data && records.data.length"
      :meta="records"
      @changePage="changePage"
    ></pagination>

    <fieldset class="dvs-fieldset dvs-mb-4" v-if="!filters.single">
      <label>Do you want the data paginated?</label>
      <toggle @change="requestRefreshRecords" v-model="filters.paginated" :id="randomString(8)"></toggle>
    </fieldset>

    <fieldset class="dvs-fieldset dvs-mb-4" v-if="!filters.single && filters.paginated">
      <label>What is the number of records per page?</label>
      <input @keyup="requestRefreshRecords" type="number" v-model="filters.limit">
    </fieldset>

    <fieldset class="dvs-fieldset dvs-mb-4">
      <label>Do you only want the first record?</label>
      <toggle @change="requestRefreshRecords" v-model="filters.single" :id="randomString(8)"></toggle>
    </fieldset>

    <fieldset class="dvs-fieldset dvs-mb-8">
      <label class="dvs-mb-8">Scopes</label>
      <ul class="dvs-list-reset dvs-mb-4" v-if="filters.scopes !== {}">
        <li
          class="dvs-mb-2 dvs-px-4 py-3 dvs-flex dvs-items-center dvs-justify-between"
          v-for="(scope, key) in filters.scopes"
          :key="key"
          :style="theme.actionButtonGhost"
        >
          {{ key }}
          <div @click="removeScope(key)">
            <close-icon class="dvs-pl-2 dvs-cursor-pointer" w="20" h="20"/>
          </div>
        </li>
      </ul>

      <div class="dvs-flex">
        <input
          class="dvs-mb-4 dvs-mr-4"
          v-model="newScope"
          placeholder="New Scope Name"
          type="text"
        >
        <input
          class="dvs-mb-4"
          v-model="newScopeProperties"
          placeholder="New Scope Properties"
          type="text"
        >
      </div>
      <button
        class="dvs-btn dvs-btn-xs"
        :style="theme.actionButtonGhost"
        @click="addScope"
      >Add Scope</button>
    </fieldset>
  </div>
</template>

<script>
import commonUtils from './../../../vuex/utils/common';

import Cell from './Cell';
import ColumnControls from './ColumnControls';
import Pagination from './Pagination';
import Strings from './../../../mixins/Strings';
import Toggle from './../Toggle';
import ToggleColumns from './ToggleColumns';

import { mapActions } from 'vuex';

export default {
  name: 'SuperTable',
  data() {
    return {
      theOptions: {
        showLinks: true
      },
      filters: {
        related: {},
        search: {},
        sort: {},
        dates: {},
        paginated: true,
        page: '1',
        limit: 5,
        single: false,
        scopes: {}
      },
      refreshRecords: null,
      records: [],
      meta: {},
      newScope: '',
      newScopeProperties: ''
    };
  },
  mounted: function() {
    // Merge options
    this.theOptions.showLinks = this.showLinks;

    if (typeof this.editData !== 'undefined') {
      for (const scope in this.editData.filters.scopes) {
        if (this.editData.filters.scopes.hasOwnProperty(scope)) {
          let s = this.editData.filters.scopes[scope];
          for (const scopeProp in s) {
            if (s.hasOwnProperty(scopeProp)) {
              this.filters.scopes[scopeProp] = s[scopeProp];
            }
          }
        }
      }

      this.$set(this.filters, 'limit', this.editData.filters.limit);
      this.$set(this.filters, 'single', this.editData.filters.single);
      this.$set(this.filters, 'page', this.editData.filters.page);
      this.$set(this.filters, 'paginated', this.editData.filters.paginated);
    }

    this.requestRefreshRecords();
  },
  methods: {
    ...mapActions('devise', ['getModelRecords']),
    updateValue() {
      let modelQuery = this.model.class + '&' + commonUtils.buildFilterParams(this.filters);
      this.$emit('input', modelQuery);
      this.$emit('change', modelQuery);
      this.$nextTick(function() {
        this.$emit('done', modelQuery);
      });
    },
    cancel() {
      this.$emit('cancel');
    },
    requestRefreshRecords() {
      let self = this;

      this.updateValue();

      clearTimeout(this.refreshRecords);

      this.refreshRecords = setTimeout(function() {
        self
          .getModelRecords({
            model: self.value,
            filters: self.filters
          })
          .then(function(response) {
            self.records = response.data;
          });
      }, 500);
    },
    changePage(page) {
      this.filters.page = page;
      this.requestRefreshRecords();
    },
    showControls(key) {
      if (this.$refs.hasOwnProperty(key) && this.$refs[key][0].show === false) {
        this.$refs[key][0].show = true;
      }
    },
    // Checks to see if the key includes a period meaning that its a property of a property
    getRecordColumn(record, key) {
      if (!key.includes('.')) {
        return record[key];
      } else {
        return this.getRecordColumnTraversal(record, key);
      }
    },
    // Get in there and get the property at the bottom of the stack
    getRecordColumnTraversal(record, key) {
      let parts = key.split('.[].');

      for (let i = 0; i < parts.length; i++) {
        var part = parts[i];

        // If it's the array part
        if (i % 2 === 1) {
          record = this.getFormattedStringFromArray(record, part);
        } else {
          record = [record].concat(part.split('.')).reduce(function(a, b) {
            return a[b];
          });
        }
      }

      return record;
    },
    getFormattedStringFromArray(record, part) {
      var finalString = '';

      for (let i = 0; i < record.length; i++) {
        if (i > 0) {
          finalString += ', ';
        }

        finalString += record[i][part];
      }

      return finalString;
    },
    showColumn(column) {
      return column.show === true || typeof column.show === 'undefined';
    },
    addScope() {
      if (this.newScope !== '') {
        this.filters.scopes[this.newScope] = this.newScopeProperties;
        this.newScope = '';
        this.newScopeProperties = '';
        this.requestRefreshRecords();
      }
    },
    removeScope(key) {
      this.$delete(this.filters.scopes, key);
      this.requestRefreshRecords();
      this.updateValue();
    }
  },
  computed: {
    theRecords() {
      if (typeof this.records.data !== 'undefined') {
        return this.records.data;
      } else if (!this.filters.single) {
        return this.records;
      } else {
        return [this.records];
      }
    }
  },
  watch: {
    model() {
      this.requestRefreshRecords();
    },
    filters() {
      this.requestRefreshRecords();
    }
  },
  props: {
    value: {
      type: String
    },
    model: {
      type: Object
    },
    columns: {
      type: Array,
      required: true
    },
    showLinks: {
      type: Boolean
    },
    editData: {
      type: Object
    }
  },
  mixins: [Strings],
  components: {
    CloseIcon: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-close.vue'),
    ColumnControls,
    ToggleColumns,
    Pagination,
    Cell,
    Toggle
  }
};
</script>
