<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputSwitch from 'primevue/inputswitch';
import { DateAdapter } from '../../util';
import { computed, onMounted, ref } from 'vue';
import { useData, filterPaused } from '../../hooks';

const props = defineProps(['date', 'openDateSelect']);

let dateString = DateAdapter.make(props.date);

const { data, dataLoaded, getData } = useData(route('report.outreach.data', { date: dateString }));

const dataFilterPaused = filterPaused(data);

const showPaused = ref(false);

const tableData = computed(() => {
    return showPaused.value ? data.value : dataFilterPaused.value;
});

const rowClass = (row) => {
    return row.paused ? 'row-paused' : '';
};

onMounted(() => {
    getData();
});
</script>

<template>
    <DataTable :value="tableData" :paginator="true" :rows="10"
        responsiveLayout="scroll"
        :rowClass="rowClass"
        class="p-datatable-sm"
        :showGridlines="true">
        <template #header>
            <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" />
            {{ date }}
            <InputSwitch v-model="showPaused"></InputSwitch>
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

<style lang="scss" scoped>
:deep .row-paused {
    background-color: var(--gray-100) !important;
    color: var(--gray-800) !important;
}
</style>