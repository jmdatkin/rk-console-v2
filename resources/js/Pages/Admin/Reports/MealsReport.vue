<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '../../../Components/DateSelect.vue';
import MealsReportTable from '../../../Components/MealsReport/MealsReportTable.vue';
import ReportWeekDataLayer from '../../../Components/ReportWeekDataLayer';
import WeekDateLinks from '../../../Components/WeekDateLinks.vue';

defineProps(['data','date']);
</script>

<template>
    <ReportLayout>
        <template #header>
            Meal Report
        </template>
        <template #report>


            <div class="p-2 shadow-sm border space-y-2 bg-white">
                <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                    @click="$inertia.visit(route('report.meals'))"></Button>
                <div class="border">
                    <WeekDateLinks :baseURL="route('report.meals')" :date="date"></WeekDateLinks>
                    <MealsReportTable :data="data" :date="date"></MealsReportTable>

                </div>

            </div>


            <!-- <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <ReportWeekDataLayer :reportComponent="MealsReportTable" :date="date" :openDateSelect="openDateSelect"
                    :requestURL="route('report.meals.data')"></ReportWeekDataLayer> -->
            <!-- <MealsReportTable :date="date" :openDateSelect="openDateSelect">
                    </MealsReportTable> -->
        </template>
    </ReportLayout>
</template>