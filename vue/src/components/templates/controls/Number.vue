<template>
  <fieldset class="dvs-fieldset">
    <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Number of example words to display</label>
    <div class="dvs-flex">
      <input type="number" class="dvs-mr-4 dvs-min-w-1/4 dvs-max-w-1/4" v-model="localValue.text" @keyup="updateValue">
      <input type="range" v-model="localValue.text" class="dvs-w-3/4" @change="updateValue">
    </div>
  </fieldset>
</template>

<script>
  export default {
    data () {
      return {
        localValue: {
          text: ''
        }
      }
    },
    mounted () {
      this.localValue = Object.assign(this.localValue, this.value)
    },
    methods: {
      updateValue () {
        this.$emit('input', this.localValue)
        this.$emit('change', this.localValue)
      }
    },
    props: ['value']
  }
</script>
