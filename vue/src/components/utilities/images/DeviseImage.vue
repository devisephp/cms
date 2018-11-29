<template>
  <img v-if="theImage" :src="theImage" :width="theImageSize.w" :height="theImageSize.h">
</template>

<script>
export default {
  computed: {
    theImageSize() {
      let sizes = this.component.fields[this.field].sizes;
      return sizes[this.currentSize];
    },
    theImage() {
      return this.devise[this.field].media[this.currentSize];
    },
    currentSize() {
      let sizes = this.component.fields[this.field].sizes;
      let self = this;
      this.$nextTick(() => {
        if (Object.keys(sizes).length) {
          for (const size in sizes) {
            if (sizes.hasOwnProperty(size)) {
              const s = sizes[size];
              if (s.breakpoints) {
                if (s.breakpoints.find(b => b.toLowerCase() === self.breakpoint.toLowerCase())) {
                  return size;
                }
              }
            }
          }
        }
      });
    }
  },
  props: {
    field: {
      required: true,
      type: String
    },
    component: {
      required: true,
      type: Object
    },
    devise: {
      required: true,
      type: Object
    }
  }
};
</script>
