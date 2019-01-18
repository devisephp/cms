<template>
  <div class="dvs-flex dvs-px-4 dvs-py-8" v-if="localFilters && localFilters.search">

    <fieldset class="dvs-w-full dvs-fieldset">
      <label class="dvs-pb-2">Search</label>

      <input type="text" class="dvs-w-full" v-model="localFilters.search[column]" @keyup="updateValue" v-if="uiType === 'field'">

      <select v-model="localFilters.search[column]" class="w-full" @change="updateValue" v-if="uiType === 'array-select'">
        <option value="">Any</option>
        <option v-for="option in options" :key="option">{{ option }}</option>
      </select>

      <select v-model="localFilters.search[column]" class="w-full" @change="updateValue" v-if="uiType === 'object-select'">
        <option value="">Any</option>
        <option v-for="(option, value) in options" :value="value" :key="option">{{ option }}</option>
      </select>

    </fieldset>
  </div>
</template>

<script>
  import Strings from './../../../mixins/Strings'

  export default {
    name: 'SuperTableSearch',
    data () {
      return {
        localFilters: null
      }
    },
    mounted () {
      let self = this
      this.$nextTick(function () {
        self.localFilters = Object.assign({}, this.localFilters, this.value)
      })
    },
    methods: {
      updateValue () {
        this.$emit('input', this.localFilters)
        this.$emit('change', this.localFilters)
      },
      clear () {
        this.localFilters = ''
        this.updateValue()
      }
    },
    computed: {
      uiType () {
        if (typeof this.options !== 'undefined') {
          if (Array.isArray(this.options)) {
            return 'array-select'
          } else {
            return 'object-select'
          }
        }

        return 'field'
      }
    },
    watch: {
      value (newValue) {
        this.localFilters = Object.assign({}, this.localFilters, newValue)
      }
    },
    props: ['value', 'column', 'options'],
    mixins: [Strings]
  }
</script>
