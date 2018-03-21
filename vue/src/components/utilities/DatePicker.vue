<template>
  <date-picker v-model="localDateTime" :config="config" class="w-full" :placeholder="placeholder" />
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
  components: {
    'date-picker': flatPickr
  },
  methods: {
    updateValue: function (value) {
      this.$emit('input', value)
    }
  },
  props: ['value', 'settings', 'placeholder']
}
</script>
