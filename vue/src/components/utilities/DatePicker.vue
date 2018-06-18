<template>
  <flat-pickr v-model="localDateTime" :config="config" class="w-full" ref="picker" :placeholder="placeholder" />
</template>

<script>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.min.css'

export default {
  data () {
    return {
      localDateTime: this.value,
      config: {
        noCalendar: !this.settings.date,
        enableTime: this.settings.time,
        onChange: this.updateValue
      }
    }
  },
  mounted () {
    this.localDateTime = this.value
  },
  components: {
    flatPickr
  },
  methods: {
    updateValue: function (value) {
      this.$emit('input', value)
      this.$emit('update', value)
      this.$refs.picker.fp.close()
    }
  },
  props: ['value', 'settings', 'placeholder']
}
</script>
