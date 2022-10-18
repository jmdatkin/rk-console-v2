<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import RouteDriverTable from '../../Components/DriversByRoute/RouteDriverTable.vue';
import WeekDateLinks from '@/Components/WeekDateLinks.vue';

defineProps(['data', 'date']);
</script>

<template>
    <DataTableLayout>
        <Head title="Drivers By Route"></Head>
        <template #header>
            Drivers by Route
        </template>
        <template #table>
            <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                @click="$inertia.visit(route('driversbyroute'))"></Button>
            <WeekDateLinks :baseURL="route('driversbyroute')" :date="date"></WeekDateLinks>
            <RouteDriverTable :date="date" :data="data"></RouteDriverTable>
        </template>
    </DataTableLayout>
</template>