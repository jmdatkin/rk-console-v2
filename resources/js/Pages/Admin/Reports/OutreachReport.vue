<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import OutreachReportTable from '../../../Components/OutreachReport/OutreachReportTable.vue';
import { useBreadcrumb } from '../../../hooks';
import ReportWeekView from '../../../Components/ReportWeekView.vue';
import OutreachReportDateLayer from '../../../Components/OutreachReport/OutreachReportDateLayer.vue';
</script>

<template>
    <ReportLayout>
        <template #header>
            Outreach Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <OutreachReportDateLayer :date="date" :openDateSelect="openDateSelect"></OutreachReportDateLayer>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>