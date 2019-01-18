<template>
  <div class="dvs-flex dvs-items-stretch">
    <div
      v-for="(column, index) in columns"
      :key="index"
      class="dvs-flex dvs-flex-col dvs-justify-between dvs-w-full"
    >
      <div
        class="dvs-font-bold dvs-mb-2 dvs-pb-2 dvs-px-2 dvs-border-b"
        :style="{borderColor: theme.panel.color}"
        @click="sortByColumn(column)"
      >
        {{ column.name }}
        <template v-if="column === sortBy">
          <arrow-down v-if="sortDir === 'desc'"/>
          <arrow-up v-else/>
        </template>
      </div>
      <div
        v-for="(record, dataKey) in sortedData"
        :key="dataKey"
        class="dvs-overflow-hidden dvs-px-2"
      >
        <template v-if="!column.property">{{ record[0] }}</template>
        <template v-else>{{ record[1][column.property] }}</template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SimpleTable',
  data() {
    return {
      sortBy: null,
      sortDir: null
    };
  },
  methods: {
    sortByColumn(column) {
      // Toggling same column
      if (this.sortBy === column) {
        if (this.sortDir === 'desc') {
          this.sortDir = null;
          this.sortBy = null;
        } else if (this.sortDir === 'asc') {
          this.sortDir = 'desc';
        } else {
          this.sortDir = 'asc';
        }
      } else {
        this.sortBy = column;
        this.sortDir = 'asc';
      }
    },
    sortNumber(a, b, direction) {
      if (direction === 'desc') {
        return b - a;
      }
      return a - b;
    },
    sortString(a, b, direction) {
      var A = a.toUpperCase(); // ignore upper and lowercase
      var B = b.toUpperCase(); // ignore upper and lowercase

      if (A < B) {
        return direction === 'desc' ? -1 : 1;
      }
      if (A > B) {
        return direction === 'desc' ? 1 : -1;
      }
    }
  },
  computed: {
    sortedData() {
      let self = this;
      var sortable = [];
      for (var record in this.data) {
        sortable.push([record, this.data[record]]);
      }

      if (this.sortBy !== null) {
        sortable.sort(function(a, b) {
          if (self.sortBy.property) {
            if (typeof a[1][self.sortBy.name] === 'string') {
              return self.sortString(
                a[1][self.sortBy.property],
                b[1][self.sortBy.property],
                self.sortDir
              );
            } else {
              return self.sortNumber(
                a[1][self.sortBy.property],
                b[1][self.sortBy.property],
                self.sortDir
              );
            }
          } else {
            if (typeof a[0] === 'string') {
              return self.sortString(a[0], b[0], self.sortDir);
            } else {
              return self.sortNumber(a[0], b[0], self.sortDir);
            }
          }
        });
      }

      return sortable;
    }
  },
  props: {
    columns: {
      required: true,
      type: Array
    },
    data: {
      required: true,
      type: Object | Array
    }
  },
  components: {
    ArrowDown: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-arrow-down.vue'),
    ArrowUp: () =>
      import(/* webpackChunkName: "js/devise-icons" */ 'vue-ionicons/dist/ios-arrow-up.vue')
  }
};
</script>
