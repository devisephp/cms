<template>
  <div class="help" :style="{
    background: theme.userText.color,
    color: theme.userBackground.color,
    borderColor: theme.userBackground.color,
  }">
    <p>
      <slot></slot>
    </p>
  </div>
</template>
