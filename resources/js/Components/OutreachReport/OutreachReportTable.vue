<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { DateAdapter } from '../../util';
import { onMounted, onUpdated, ref, watch } from 'vue';
import { useData } from '../../hooks';
import axios from 'axios';

// const props = defineProps(['date', 'openDateSelect']);
const props = defineProps(['data', 'date', 'openDateSelect']);

// const { data, dataLoaded, getData } = useData(route('report.outreach.data', { date: DateAdapter.make(props.date) }));

// onMounted(() => {
//     getData();
// });
</script>

<template>
    <DataTable :value="data" :paginator="true" :rows="10"
        responsiveLayout="scroll"
        class="p-datatable-sm"
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