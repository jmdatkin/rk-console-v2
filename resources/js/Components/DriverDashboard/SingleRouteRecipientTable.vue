<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

defineProps(['data', 'onRowSelect']);
</script>

<template>
<DataTable responsiveLayout="scroll" :value="data" @row-select="onRowSelect"
selectionMode="single">
    <Column field="id" header="id"></Column>
    <Column field="person.firstName" header="First"></Column>
    <Column field="person.lastName" header="Last"></Column>
    <Column field="address" header="Address"></Column>
    <Column field="numMeals" header="Num. Meals"></Column>
    <Column field="person.phoneHome" header="Home Phone"></Column>
    <Column field="person.phoneCell" header="Cell Phone"></Column>
    <Column field="person.notes" header="Notes"></Column>
</DataTable>
</template>

<style lang="scss">
</style>