<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { DateAdapter, visitRecipient } from '../../util';

const props = defineProps(['data', 'date', 'openDateSelect']);

</script>

<template>
    <DataTable :value="data" rowGroupMode="subheader" sortField="name" groupRowsBy="name" :paginator="true" :rows="10"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        @row-select="e => visitRecipient(e.data.recipient_id)"
        selectionMode="single"
        :showGridlines="true">
        <template #header>
            {{ DateAdapter.format(date) }}
        </template>

        <template #loading>
            Loading data...
        </template>
        <template #empty>
            No records found.
        </template>

        <Column header="Recip. id" field="recipient_id"></Column>
        <Column header="Recip. First" field="firstName"></Column>
        <Column header="Recip. Last" field="lastName"></Column>
        <Column header="Num. Meals" field="numMeals"></Column>
        <Column header="Address" field="address"></Column>
        <Column header="Home Phone" field="phoneHome"></Column>
        <Column header="Cell Phone" field="phoneCell"></Column>
        <Column header="Notes" field="notes"></Column>

        <template #groupheader="slotProps">
            <span class="flex">
                <span class="flex-grow"><strong>{{ slotProps.data.name }}</strong></span>
                <span class="flex-grow text-right"><strong>Total Num. Meals: {{ slotProps.data.agg_num_meals }}</strong></span>
            </span>
        </template>
    </DataTable>
</template>

<style lang="scss">
.p-datatable .p-datatable-tbody>tr.p-rowgroup-header td {
    border-top-width: 3px;
}

.p-datatable.p-datatable-gridlines .p-datatable-tbody>tr>td.p-dt-footer-cell {
    border-bottom-width: 3px;
}

.p-datatable.p-datatable-gridlines .p-datatable-tbody>tr>td.p-dt-subheader-cell {
    border-top-width: 3px;
}
</style>