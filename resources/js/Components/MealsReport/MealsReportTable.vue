<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { DateAdapter } from '../../util';
import { onMounted } from 'vue';
import { useData } from '../../hooks';

const props = defineProps(['date', 'openDateSelect']);

let dateString = DateAdapter.make(props.date);

const { data, dataLoaded, getData } = useData(route('report.meals.data', { date: dateString }));

onMounted(() => {
    getData();
});
</script>

<template>
    <DataTable :value="data" rowGroupMode="subheader" groupRowsBy="name" :paginator="true" :rows="10"
        responsiveLayout="scroll"
        class="p-datatable-sm"
        :showGridlines="true">
        <template #header>
            <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" />
            {{ date }}
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

        <template #groupheader="slotProps">
            <!-- <td colspan="5">
                <span><strong>{{ slotProps.data.name }}</strong></span>
            </td> -->
            <!-- <td class="p-dt-subheader-cell flex"> -->
            <span class="flex">
                <span class="flex-grow"><strong>{{ slotProps.data.name }}</strong></span>
                <span class="flex-grow text-right"><strong>Total Num. Meals: {{ slotProps.data.agg_num_meals }}</strong></span>
            </span>
            <!-- </td> -->
        </template>
        <!-- <template #groupfooter="slotProps">
            <td class="p-dt-footer-cell" colspan="5">
                <span><strong>Total Num. Meals: {{ slotProps.data.agg_num_meals }}</strong></span>
            </td>
        </template> -->
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