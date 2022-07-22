<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import TotalsReportTable from '../../../Components/TotalsReport/TotalsReportTable.vue';
</script>

<template>
    <ReportLayout>
        <template #header>
            Totals Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <TotalsReportTable :date="date" :openDateSelect="openDateSelect">
                    </TotalsReportTable>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>