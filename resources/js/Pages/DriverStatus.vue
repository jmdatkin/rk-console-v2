<script setup>
import Calendar from '@/Components/Calendar';
import ReportLayout from '@/Layouts/ReportLayout';
import Dialog from 'primevue/dialog';
import { ref, reactive } from 'vue';

const dialogOpen = ref(false);
const selectedDates = reactive({
    start: null,
    end: null
});

const dateSelectCallback = function(date) {
    selectedDates.start = date.start;
    selectedDates.end = date.end;
    dialogOpen.value = true;
};
</script>

<template>
<ReportLayout>
    <Dialog v-model:visible="dialogOpen">
        Hi
    </Dialog>
    <template #report>
        <Calendar :onSelectCallback="dateSelectCallback"></Calendar>
    </template>
</ReportLayout>
</template>