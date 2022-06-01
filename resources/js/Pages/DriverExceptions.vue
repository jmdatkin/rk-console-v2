<script setup>
import Calendar from '@/Components/Calendar';
import PrimeVueCalendar from 'primevue/calendar';
import ReportLayout from '@/Layouts/ReportLayout';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { ref, reactive, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['driverData', 'exceptions']);

const dialogOpen = ref(false);

const dateSelectCallback = function (date) {
    driverExceptionForm.date_start = date.start;
    driverExceptionForm.date_end = date.end;
    dialogOpen.value = true;
};


const driverExceptionForm = reactive({
    driver_id: props.driverData.id,
    date_start: null,
    date_end: null,
    notes: null
});

const driverExceptionSubmit = function () {
    Inertia.post('/exceptions/store', driverExceptionForm);
};

</script>

<template>
    <ReportLayout>
        <Dialog v-model:visible="dialogOpen">
            <form @submit.prevent="driverExceptionSubmit">
                <PrimeVueCalendar v-model="driverExceptionForm.date_start"></PrimeVueCalendar>
                <PrimeVueCalendar v-model="driverExceptionForm.date_end"></PrimeVueCalendar>
                <Textarea v-model="driverExceptionForm.notes"></Textarea>
                <Button type="submit">Submit</Button>
            </form>
        </Dialog>
        <template #report>
            <Calendar :events="exceptions" :onSelectCallback="dateSelectCallback"></Calendar>
        </template>
    </ReportLayout>
</template>