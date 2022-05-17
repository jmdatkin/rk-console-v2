<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DriverReportDataTable from './DriverReportDataTable';

defineProps(['data','driverData']);

</script>

<template>
    <ReportLayout>
        <template #header>
            Driver Report
        </template>
        <template #report>
            <DriverReportDataTable :data="data" :driverData="driverData"></DriverReportDataTable>
        </template>
    </ReportLayout>
</template>