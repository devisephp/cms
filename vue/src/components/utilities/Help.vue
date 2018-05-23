<template>
  <div class="help" :style="{
    background: theme.userBackground.color,
    color: theme.userText.color,
    borderColor: theme.userText.color,
    boxShadow: `-4px -4px ${theme.userShadowSize.text} ${theme.userShadowColor.color}`
  }">
    <p>
      <slot></slot>
    </p>
  </div>
</template>
