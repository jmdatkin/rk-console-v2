<script setup>
defineProps(['title', 'icon']);
</script>

<template>
    <div class="p-info-item">
        <span class="p-info-item-header">
            <i v-if="icon" :class="icon"></i>
            {{ title }}
        </span>
        <span class="p-info-item-value">
            <slot></slot>
        </span>
    </div>
</template>

<style lang="scss">
.p-info-item {
    display: flex;
    flex-direction: column;
}

.p-info-item-header {
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: 600;
}
</style>