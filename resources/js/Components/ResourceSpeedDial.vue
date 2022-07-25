<script setup>
import SpeedDial from 'primevue/speeddial';
import { ref } from 'vue';

const props = defineProps(['handleCreate', 'handleEdit', 'handleDelete'])

const items = ref([
    {
        label: 'Create',
        icon: 'pi pi-plus',
        command: props.handleCreate
    },
    {
        label: 'Delete',
        icon: 'pi pi-trash',
        command: props.handleDelete
    },
    {
        label: 'Clear Filters',
        icon: 'pi pi-filter',
        command: props.handleClearFilters
    },
]);
</script>

<template>
    <SpeedDial :model="items"></SpeedDial>
</template>