<template>
  <div 
      class="dvs-w-2/5 dvs-border dvs-rounded dvs-bg-grey dvs-mb-8 dvs-p-8 dvs-cursor-pointer" 
      :class="{'dvs-w-full': open, 'dvs-bg-green dvs-text-white': item}"
      @click="open = !open"
    >
      
      <close-circle-icon w="50" h="50" v-if="!item" />
      <checkmark-icon w="50" h="50" v-else />
      
      <h3 class="dvs-my-4">{{title}}</h3>
      <div class="dvs-text-sm" v-if="open">
        <slot></slot>
      </div>
    </div>
</template>

<script>
export default {
  data () {
    return {
      open: false
    }
  },
  props: {
    item: {
      required: true,
      type: Boolean
    },
    title: {
      required: true,
      type: String
    }
  }
}
</script>
