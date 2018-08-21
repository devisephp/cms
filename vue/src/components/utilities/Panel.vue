<template>
  <div class="dvs-panel" v-tilt>
    <div class="dvs-panel-contents" :style="panelStyle">
      <div class="dvs-panel-shine-container">
        <div class="dvs-panel-shine"></div>
      </div>

      <slot />
    
    </div>
  </div>
</template>


<script>
export default {
  props: {
    panelStyle: {
      default: null,
      type: Object
    }
  }
}
</script>
