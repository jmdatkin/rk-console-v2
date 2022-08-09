<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import OutreachReportTable from '../../../Components/OutreachReport/OutreachReportTable.vue';
import ReportWeekDataLayer from '../../../Components/ReportWeekDataLayer.vue';
import ReportWeekView from '../../../Components/ReportWeekView.vue';
import OutreachReportTable1 from '../../../Components/OutreachReport/OutreachReportTable.vue';
import { Inertia } from '@inertiajs/inertia';
import WeekDateLinks from '../../../Components/WeekDateLinks.vue';
import { back } from '@/util';

defineProps(['data', 'date']);

const handleSelect = function(date) {
    Inertia.visit(`${route('report.outreach.report')}/${date}`);
};

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

            <!-- <DateSelect>
                <template v-slot="{ date, openDateSelect }"> -->
                    <!-- <OutreachReportDateLayer :date="date" :openDateSelect="openDateSelect"></OutreachReportDateLayer> -->
                    <!-- <ReportWeekView @weekday-select="handleSelect"></ReportWeekView> -->
                    <div class="p-2 shadow-sm border space-y-2 bg-white">
                    <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back" @click="$inertia.visit(route('report.outreach'))"></Button>
                        <div class="border">
                    <WeekDateLinks :baseURL="route('report.outreach')" :date="date"></WeekDateLinks>
                    <OutreachReportTable :data="data" :date="date"></OutreachReportTable>

                        </div>

                    </div>

                    <!-- <ReportWeekDataLayer :reportComponent="OutreachReportTable" :date="date"
                    :getDataFunction="getDataFunction"
                    :requestURL="route('report.outreach.data')"
                    ></ReportWeekDataLayer> -->
                <!-- </template>
            </DateSelect> -->
        </template>
    </ReportLayout>
</template>