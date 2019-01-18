<template>
  <ul v-if="listMode" class="dvs-list-reset dvs-flex">
    <li v-for="n in meta.last_page" @click="update(n)"
    :key="n"
    :class="{ 'dvs-current-page': isCurrentPage(n) }"
    class="dvs-btn dvs-btn-xs dvs-mr-1 dvs-cursor-pointer"
    :style="decideStyle(n)">
      {{ n }}
    </li>
  </ul>
  <div class="dvs-flex" v-else>
    <button @click="changePage(1)" class="dvs-btn dvs-btn-xs dvs-mr-1" :style="this.theme.actionButtonGhost">First</button>
    <button @click="changePage(meta.current_page - 1)"  class="dvs-btn dvs-btn-xs dvs-mr-1" :style="this.theme.actionButtonGhost">Prev</button>
    <select :value="meta.current_page" @change="changePage($event.target.value)" class="dvs-p-2 dvs-mr-1 dvs-text-xs dvs-appearance-none">
      <option v-for="n in meta.last_page" :key="n" :value="n">
        {{ n }}
      </option>
    </select>
    <button @click="changePage(meta.current_page + 1)" class="dvs-btn dvs-btn-xs dvs-mr-1" :style="this.theme.actionButtonGhost">Next</button>
    <button @click="changePage(meta.last_page)" class="dvs-btn dvs-btn-xs dvs-mr-1" :style="this.theme.actionButtonGhost">Last</button>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'SuperTablePagination',
  methods: {
    ...mapActions([
      'updateFilters'
    ]),
    changePage (page) {
      if (page > 0 && page <= this.meta.last_page) {
        this.$emit('changePage', page)
      }
    },
    isCurrentPage (page) {
      return page === this.meta.current_page
    },
    decideStyle (page) {
      if (this.isCurrentPage(page)) {
        return this.theme.actionButton
      } 
      return this.theme.actionButtonGhost
    }
  },
  computed: {
    ...mapGetters([
      'filters'
    ])
  },
  props: ['meta', 'listMode']
}
</script>
