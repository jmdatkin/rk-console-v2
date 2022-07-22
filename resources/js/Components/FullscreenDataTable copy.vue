<script setup>
import Sidebar from 'primevue/sidebar';
import { ref } from 'vue';

const visible = ref(false);

</script>

<template>
    <Button @click="() => visible = true" class="p-button-rounded" icon="pi pi-window-maximize"></Button>
    <Sidebar v-if="visible" v-model:visible="visible" position="full" style="z-index: 1099">
        <slot ></slot>
    </Sidebar>
    <slot v-else ></slot>
</template>

<style lang="scss">
    // html .p-sidebar {
    //     z-index: 1001;
    // }

    html .p-sidebar .p-sidebar-content {
        padding: 0;
    }

    html .p-sidebar .p-sidebar-header {
        padding: 0;
        // position: absolute;
        
    }
</style>