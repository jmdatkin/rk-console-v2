<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

defineProps(['data','onSelect'])

</script>

<template>
    <DataTable @rowSelect="onSelect"
        selectionMode="single" :value="data">
        <Column header="id" field="id">
        </Column>
        <Column header="firstName" field="person.firstName">
        </Column>
        <Column header="lastName" field="person.lastName">
        </Column>
    </DataTable>

</template>