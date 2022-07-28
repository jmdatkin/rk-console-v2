<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import OutreachReportTable from '../../../Components/OutreachReport/OutreachReportTable.vue';
import { useBreadcrumb } from '../../../hooks';
import ReportWeekView from '../../../Components/ReportWeekView.vue';
import OutreachReportDateLayer from '../../../Components/OutreachReport/OutreachReportDateLayer.vue';
import ReportWeekDataLayer from '../../../Components/ReportWeekDataLayer.vue';
// import route from '../../../../../vendor/tightenco/ziggy/src/js';

const getDataFunction = function(date) {
    return axios.create({
        baseURL: route('report.outreach.data'),
        // data: { date },
        method: 'get'
    });
};
</script>

<template>
    <ReportLayout>
        <template #header>
            Outreach Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <!-- <OutreachReportDateLayer :date="date" :openDateSelect="openDateSelect"></OutreachReportDateLayer> -->
                    <ReportWeekDataLayer :reportComponent="OutreachReportTable" :date="date" :openDateSelect="openDateSelect"
                    :getDataFunction="getDataFunction"
                    :requestURL="route('report.outreach.data')"
                    ></ReportWeekDataLayer>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>