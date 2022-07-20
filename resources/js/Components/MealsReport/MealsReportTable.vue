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
        :showGridlines="true">
        <template #header>
            <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" />
            {{ date }}
        </template>

        <Column header="First" field="firstName"></Column>
        <Column header="Last" field="lastName"></Column>
        <Column header="Num. Meals" field="numMeals"></Column>
        <Column header="Address" field="address"></Column>
        <Column header="Notes" field="notes"></Column>

        <template #groupheader="slotProps">
            <td colspan="5">
                <span>{{ slotProps.data.name }}</span>
            </td>
        </template>
        <template #groupfooter="slotProps">
            <td colspan="5">
                <span>{{ slotProps.data.agg_num_meals }}</span>
            </td>
        </template>
    </DataTable>
</template>

<style lang="scss">
</style>