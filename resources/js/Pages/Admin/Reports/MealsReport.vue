<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import MealsReportTable from '../../../Components/MealsReport/MealsReportTable.vue';
import WeekDateLinks from '../../../Components/WeekDateLinks.vue';

defineProps(['data', 'date']);
</script>

<template>
    <ReportLayout>
        <template #header>
            Meal Report
        </template>
        <template #report>
            <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                @click="$inertia.visit(route('report.meals'))"></Button>
            <div class="border">
                <WeekDateLinks :baseURL="route('report.meals')" :date="date"></WeekDateLinks>
                <MealsReportTable :data="data" :date="date"></MealsReportTable>
            </div>
        </template>
    </ReportLayout>
</template>