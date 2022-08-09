<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import TotalsReportTable from '../../../Components/TotalsReport/TotalsReportTable.vue';
import FullscreenDataTable from '../../../Components/FullscreenDataTable.vue';

defineProps(['data','date']);

</script>

<template>
    <ReportLayout>
        <template #header>
            Totals Report
        </template>
        <template #report>

            <div class="p-2 shadow-sm border space-y-2 bg-white">
                <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                    @click="$inertia.visit(route('report.totals'))"></Button>
                <div class="border">
                    <WeekDateLinks :baseURL="route('report.totals')" :date="date"></WeekDateLinks>
                    <TotalsReportTable :date="date" :data="data">
                    </TotalsReportTable>

                </div>
            </div>
        </template>
    </ReportLayout>
</template>