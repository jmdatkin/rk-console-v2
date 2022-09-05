<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import TotalsReportTable from '../../../Components/TotalsReport/TotalsReportTable.vue';

defineProps(['data', 'date']);

</script>

<template>
    <ReportLayout>
        <template #header>
            Totals Report
        </template>
        <template #report>
            <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                @click="$inertia.visit(route('report.totals'))"></Button>
            <div class="border">
                <WeekDateLinks :baseURL="route('report.totals')" :date="date"></WeekDateLinks>
                <TotalsReportTable :date="date" :data="data">
                </TotalsReportTable>
            </div>
        </template>
    </ReportLayout>
</template>