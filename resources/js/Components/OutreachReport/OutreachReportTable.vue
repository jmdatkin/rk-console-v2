<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { DateAdapter, visitRecipient } from '../../util';

const props = defineProps(['data', 'date', 'openDateSelect']);

</script>

<template>
    <DataTable :value="data" :paginator="true" :rows="10"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        @row-select="e => visitRecipient(e.data.recipient_id)"
        selectionMode="single"
        :showGridlines="true">
        <template #header>
            <!-- <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" /> -->
            {{ DateAdapter.format(date) }}
        </template>

        <template #loading>
            Loading data...
        </template>
        <template #empty>
            No records found.
        </template>

        <Column header="First" field="firstName"></Column>
        <Column header="Last" field="lastName"></Column>
        <Column header="Num. Meals" field="numMeals"></Column>
        <Column header="Address" field="address"></Column>
        <Column header="Notes" field="notes"></Column>
    </DataTable>
</template>

<style lang="scss">
</style>