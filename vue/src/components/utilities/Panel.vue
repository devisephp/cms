<template>
  <div class="dvs-panel">
    <div class="dvs-panel-contents dvs-max-h-screen" :style="panelStyle">
      <div class="dvs-panel-shine-container">
        <div class="dvs-panel-shine"></div>
      </div>

      <div data-simplebar>
        <slot />
      </div>
    
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
