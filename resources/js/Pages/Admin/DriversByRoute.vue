<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import DateSelect from '@/Components/DateSelect';
// import Content from '@/Components/DriversByRoute/Content';
import RouteDriverTable from '../../Components/DriversByRoute/RouteDriverTable.vue';
</script>

<template>
    <DataTableLayout>
        <Head title="Drivers By Route"></Head>
        <template #header>
            Drivers by Route
        </template>
        <template #table>
            <DateSelect :limitSelect="true">
                <template v-slot="{ date, openDateSelect }">
                    <!-- <Content :openDateSelect="openDateSelect" :date="date"></Content> -->
                    <RouteDriverTable :date="date" :openDateSelect="openDateSelect"></RouteDriverTable>
                </template>
            </DateSelect>
        </template>
    </DataTableLayout>
</template>