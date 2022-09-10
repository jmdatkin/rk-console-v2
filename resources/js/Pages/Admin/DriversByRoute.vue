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
            <!-- <DateSelect :limitSelect="true">
                <template v-slot="{ date, openDateSelect }"> -->
                    <!-- <Content :openDateSelect="openDateSelect" :date="date"></Content> -->
                <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                    @click="$inertia.visit(route('driversbyroute'))"></Button>
                <!-- <div class="border"> -->
                    <WeekDateLinks :baseURL="route('driversbyroute')" :date="date"></WeekDateLinks>
                    <RouteDriverTable :date="date" :data="data"></RouteDriverTable>
                <!-- </div> -->
                <!-- </template>
            </DateSelect> -->
        </template>
    </DataTableLayout>
</template>