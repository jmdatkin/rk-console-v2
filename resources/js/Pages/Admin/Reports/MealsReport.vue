<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import MealsReportTable from '../../../Components/MealsReport/MealsReportTable.vue';
import ReportWeekDataLayer from '../../../Components/ReportWeekDataLayer';
</script>

<template>
    <ReportLayout>
        <template #header>
            Meal Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <ReportWeekDataLayer :reportComponent="MealsReportTable" :date="date" :openDateSelect="openDateSelect"
                    :requestURL="route('report.meals.data')"></ReportWeekDataLayer>
                    <!-- <MealsReportTable :date="date" :openDateSelect="openDateSelect">
                    </MealsReportTable> -->
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>