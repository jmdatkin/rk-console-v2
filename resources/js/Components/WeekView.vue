<script setup>
</script>

<template>

  <div class="week-view">
    <div class="header">
      <slot name="header"></slot>
    </div>
    <div class="week-view-container">
      <slot />
    </div>
  </div>

</template>

<style scoped lang="scss">
.week-view {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.week-view-container {
  display: flex;
  width: 100%;
}
</style>