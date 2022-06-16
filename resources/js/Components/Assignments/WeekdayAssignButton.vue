<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';

defineProps(['title', 'onSelect', 'data']);

</script>

<template>
    <div class="flex flex-col">
        <span class="p-info-item-header">{{ title }}</span>
        <DataTable class="p-datatable-sm" :value="data">
            <Column field="id" header="id"></Column>
            <Column field="name" header="name"></Column>
            <Column field="notes" header="notes"></Column>
        </DataTable>
        <Button class="p-button-text p-button-sm" @click="onSelect">Select Route</Button>
    </div>
</template>