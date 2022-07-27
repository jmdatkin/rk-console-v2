<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import OutreachReportTable from '../../../Components/OutreachReport/OutreachReportTable.vue';
import { useBreadcrumb } from '../../../hooks';
import ReportWeekView from '../../../Components/ReportWeekView.vue';
import axios from 'axios';

// const data = ref([]);

// const getData = function(day) {
//     axios.get(route('report.outreach.data', { date: day }))
//     .then(res => {
//         data.value = res.data;
//     });
// };

// const onTabChange = function(idx) {

// }

</script>

<template>
    <ReportLayout>
        <template #header>
            Outreach Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <ReportWeekView>
                        <!-- <ReportWeekViewAttrLayer>
                            <OutreachReportTable :date="date" :openDateSelect="openDateSelect">
                            </OutreachReportTable>
                        </ReportWeekViewAttrLayer> -->
                    </ReportWeekView>
                    <OutreachReportTable :date="date" :openDateSelect="openDateSelect">
                    </OutreachReportTable>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>