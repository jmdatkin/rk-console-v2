<script setup>
import Sidebar from 'primevue/sidebar';
import { ref } from 'vue';

const visible = ref(false);

</script>

<template>
    <Button @click="() => visible = true" class="p-button-rounded" icon="pi pi-window-maximize"></Button>
    <Sidebar v-if="visible" v-model:visible="visible" position="full">
        <slot ></slot>
    </Sidebar>
    <slot v-else ></slot>
</template>

<style lang="scss">
    html .p-sidebar .p-sidebar-content {
        padding: 0;
    }
</style>