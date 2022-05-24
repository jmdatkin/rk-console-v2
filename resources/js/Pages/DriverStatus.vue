<script setup>
import Calendar from '@/Components/Calendar';
import PrimeVueCalendar from 'primevue/calendar';
import ReportLayout from '@/Layouts/ReportLayout';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['driverData', 'statuses']);

const dialogOpen = ref(false);
// const selectedDates = reactive({
//     start: null,
//     end: null
// });

const dateSelectCallback = function (date) {
    driverStatusForm.date_start = date.start;
    driverStatusForm.date_end = date.end;
    dialogOpen.value = true;
};


const driverStatusForm = reactive({
    driver_id: props.driverData.id,
    date_start: null,
    date_end: null,
    notes: null
});

const driverStatusSubmit = function () {
    Inertia.post('/driverstatus/store', driverStatusForm);
};

</script>

<template>
    <ReportLayout>
        <Dialog v-model:visible="dialogOpen">
            <form @submit.prevent="driverStatusSubmit">
                <PrimeVueCalendar v-model="driverStatusForm.date_start"></PrimeVueCalendar>
                <PrimeVueCalendar v-model="driverStatusForm.date_end"></PrimeVueCalendar>
                <Textarea v-model="driverStatusForm.notes"></Textarea>
                <Button type="submit">Submit</Button>
            </form>
        </Dialog>
        <template #report>
            <Calendar :events="statuses" :onSelectCallback="dateSelectCallback"></Calendar>
        </template>
    </ReportLayout>
</template>