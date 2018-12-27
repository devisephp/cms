<template>
  <div 
    class="dvs-p-4 dvs-text-base dvs-border-l-8" 
    :style="{
      backgroundColor: theme.help.background, 
      color: theme.help.color, 
      borderColor: theme.help.color
    }">
    <p>
      <slot></slot>
    </p>
  </div>
</template>
