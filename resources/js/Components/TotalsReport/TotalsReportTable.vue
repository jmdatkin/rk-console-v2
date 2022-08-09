<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import Button from 'primevue/button';
import { DateAdapter } from '../../util';
import { onMounted } from 'vue';
import { useData } from '../../hooks';
import { WEEKDAYS } from '@/constants';

const props = defineProps(['date', 'data']);

// let dateString = DateAdapter.make(props.date);

// const { data, dataLoaded, getData } = useData(route('report.totals.data'));

// onMounted(() => {
//     getData();
// });
</script>

<template>
    <DataTable :value="data" :paginator="true" :rows="10" responsiveLayout="scroll" class="p-datatable-sm"
        sortField="weekday"
        rowGroupMode="rowspan" groupRowsBy="weekday" :showGridlines="true">
        <template #header>
            {{ DateAdapter.format(date) }}
        </template>

        <template #loading>
            Loading data...
        </template>
        <template #empty>
            No records found.
        </template>

        <ColumnGroup type="header">
            <Row>
                <Column header="Day" :rowspan="2" field="weekday"></Column>
                <Column header="Route" :colspan="3" field="route_name"></Column>
                <Column header="Driver" :colspan="5">
                </Column>
            </Row>
            <Row>
                <!-- <Column header="Day" field="weekday"></Column> -->
                <Column header="id" field="route_id"></Column>
                <Column header="Name" field="route_name"></Column>
                <Column header="# Meals" field="totalNumMeals"></Column>
                <Column header="id" field="driver_id"></Column>
                <Column header="First" field="driver_firstName"></Column>
                <Column header="Last" field="driver_lastName"></Column>
                <Column header="Home Phone" field="driver_phoneHome"></Column>
                <Column header="Cell Phone" field="driver_phoneCell"></Column>
            </Row>
        </ColumnGroup>

        <Column header="Day" field="weekday">
            <template #body="{data}">
                {{ WEEKDAYS[data.weekday] }}
            </template>
        </Column>
                <Column header="id" field="route_id"></Column>
                <Column header="Name" field="route_name"></Column>
                <Column header="# Meals" field="totalNumMeals"></Column>
                <Column header="id" field="driver_id"></Column>
                <Column header="First" field="driver_firstName"></Column>
                <Column header="Last" field="driver_lastName"></Column>
                <Column header="Home Phone" field="driver_phoneHome"></Column>
                <Column header="Cell Phone" field="driver_phoneCell"></Column>
        <!-- <Column header="Notes" field="notes"></Column> -->
    </DataTable>
</template>

<style lang="scss">
</style>