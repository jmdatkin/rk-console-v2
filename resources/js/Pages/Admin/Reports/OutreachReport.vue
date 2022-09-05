<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import OutreachReportTable from '../../../Components/OutreachReport/OutreachReportTable.vue';
import WeekDateLinks from '../../../Components/WeekDateLinks.vue';

defineProps(['data', 'date']);

</script>

<template>
    <ReportLayout>
        <template #header>
            Outreach Report
        </template>
        <template #report>
                <Button class="p-button-outlined" icon="pi pi-chevron-left" label="Back"
                    @click="$inertia.visit(route('report.outreach'))"></Button>
                <div class="border">
                    <WeekDateLinks :baseURL="route('report.outreach')" :date="date"></WeekDateLinks>
                    <OutreachReportTable :data="data" :date="date"></OutreachReportTable>
                </div>
        </template>
    </ReportLayout>
</template>