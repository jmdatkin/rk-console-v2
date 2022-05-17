<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DriverReportDataTable from './DriverReportDataTable';

defineProps(['data', 'driverData']);

</script>

<template>
    <ReportLayout>
        <template #title>
            Driver Report
        </template>
        <template #header>
        <span>Driver: {{ driverData.person.firstName }} {{ driverData.person.lastName }}</span>
        </template>
        <template #report>
            <DriverReportDataTable :data="data" :driverData="driverData"></DriverReportDataTable>
        </template>
    </ReportLayout>
</template>