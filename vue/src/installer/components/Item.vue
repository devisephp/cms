<template>
  <section>
    <div class="dvs-relative dvs-pl-16">
      <item-check
        v-if="item !== null"
        :item="item"
        class="dvs-absolute dvs-pin-t dvs-pin-l dvs-ml-6 dvs-mt-8"
      ></item-check>
      <div class="dvs-pl-8">
        <h3 class="dvs-mb-4">{{ title }}</h3>
        <slot name="instructions"/>
      </div>
    </div>

    <div>
      <slot name="example"></slot>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    item: {
      type: Boolean,
      default: null
    },
    title: {
      required: true,
      type: String
    }
  }
};
</script>
