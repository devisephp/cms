<template>
  <div>
    <fieldset class="dvs-fieldset mb-4">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Text</label>
      <input type="text" class="dvs-mr-4 dvs-w-full" v-model="localValue.text" @keyup="updateValue">
    </fieldset>
    <fieldset class="dvs-fieldset mb-4">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">URL</label>
      <input type="text" class="dvs-mr-4 dvs-w-full" v-model="localValue.URL" @keyup="updateValue">
    </fieldset>
    <fieldset class="dvs-fieldset">
      <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Target</label>
      <select v-model="localValue.target">
        <option value="_self">Same Window</option>
        <option value="_blank">New Window / Tab</option>
      </select>
    </fieldset>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        localValue: {
          text: '',
          url: '',
          target: ''
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
