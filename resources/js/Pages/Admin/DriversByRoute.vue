<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import DateSelect from '@/Components/DateSelect';
import Content from '@/Components/DriversByRoute/Content';
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
                    <Content :openDateSelect="openDateSelect" :date="date"></Content>
                </template>
            </DateSelect>
        </template>
    </DataTableLayout>
</template>