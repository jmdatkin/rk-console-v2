<script setup>
import Sidebar from 'primevue/sidebar';
import { ref } from 'vue';

const visible = ref(false);

</script>

<template>
    <Sidebar v-if="visible" v-model:visible="visible" position="full" style="z-index: 1099">
        <DataTable v-bind="$attrs">
            <template #header>
                <slot name="header"></slot>
            </template>
            <slot></slot>
        </DataTable>
    </Sidebar>
    <DataTable v-else v-bind="$attrs">
        <template #header>
            <slot name="header"></slot>
            <Button @click="() => visible = true" class="p-button-rounded" icon="pi pi-window-maximize"></Button>
        </template>
        <slot></slot>
    </DataTable>
</template>

<style lang="scss">

html .p-sidebar .p-sidebar-content {
    padding: 0;
}

html .p-sidebar .p-sidebar-header {
    padding: 0;
    // position: absolute;

}
</style>