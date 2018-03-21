<template>
  <fieldset class="dvs-fieldset">
    <label class="dvs-small-label dvs-text-grey-darker dvs-italic">Hex Value</label>
    <div class="dvs-flex">
      <input type="text" class="dvs-mr-4 dvs-w-full" v-model="localValue.color" @keyup="updateValue">
    </div>
  </fieldset>
</template>

<script>
  export default {
    data () {
      return {
        localValue: {
          color: ''
        }
      }
    },
    mounted () {
      this.localValue = Object.assign(this.localValue, this.value)
    },
    methods: {
      updateValue () {
        if (this.localValue.color.charAt(0) !== '#') {
          this.localValue.color = '#' + this.localValue.color
        }
        this.$emit('input', this.localValue)
        this.$emit('change', this.localValue)
      }
    },
    props: ['value']
  }
</script>
