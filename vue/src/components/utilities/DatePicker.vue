<template>
  <flat-pickr
    v-model="localDateTime"
    :config="config"
    class="w-full"
    ref="picker"
    :placeholder="placeholder"
  />
</template>

<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.min.css';
import dayjs from 'dayjs';

export default {
  data() {
    return {
      localDateTime: null,
      config: {
        noCalendar: !this.settings.date,
        enableTime: this.settings.time,
        onChange: this.updateValue
      }
    };
  },
  mounted() {
    this.localDateTime = this.value;
  },
  methods: {
    updateValue(value) {
      value = this.formatValue(value);
      this.$emit('input', value);
      this.$emit('update', value);
    },
    formatValue(value) {
      if (this.settings.format) {
        return dayjs(value).format(this.settings.format);
      }

      // 2018-04-27 13:34:00
      if (this.settings.date && this.settings.time) {
        return dayjs(value).format('YYYY-MM-DD HH:mm:ss');
      }
      // 2018-04-27
      if (this.settings.date && !this.settings.time) {
        return dayjs(value).format('YYYY-MM-DD');
      }
      // 13:34:00
      if (!this.settings.date && this.settings.time) {
        return dayjs(value).format('HH:mm:ss');
      }

      return null;
    },
    resetPicker() {
      this.localDateTime = null;
    }
  },
  components: {
    flatPickr
  },
  props: ['value', 'settings', 'placeholder']
};
</script>
