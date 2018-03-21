<template>
  <ul class="pagination" v-if="meta.pagination && meta.pagination.total_pages > 1">
    <li v-for="n in meta.pagination.total_pages" @click="update(n)"
    class="ghost"
    :class="{ 'bg-action': isCurrentPage(n) }">
      {{ n }}
    </li>
  </ul>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'SuperTablePagination',
  methods: {
    ...mapActions([
      'updateFilters'
    ]),
    update (page) {
      let filterPayload = {}

      filterPayload[this.type] = this.filters[this.type]
      filterPayload[this.type].page = page

      this.updateFilters(filterPayload)
    },
    isCurrentPage (page) {
      return page === this.meta.pagination.current_page
    }
  },
  computed: {
    ...mapGetters([
      'filters'
    ])
  },
  props: ['meta', 'type']
}
</script>
