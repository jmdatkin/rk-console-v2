<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import OutreachReportTable from '../../../Components/OutreachReport/OutreachReportTable.vue';
</script>

<template>
    <ReportLayout>
        <template #header>
            Outreach Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <OutreachReportTable :date="date" :openDateSelect="openDateSelect">
                    </OutreachReportTable>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>