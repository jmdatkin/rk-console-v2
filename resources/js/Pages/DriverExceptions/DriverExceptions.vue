
<script setup>
import Calendar from '@/Components/Calendar';
import PrimeVueCalendar from 'primevue/calendar';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { ref, reactive, computed, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['driverData']);

const exceptions = ref([]);
const getExceptions = function() {
    axios.get(`/exceptions/${props.driverData.id}/data`)
    .then(res => exceptions.value = res.data);
};

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

onMounted(() => {
    getExceptions();
});

</script>

<template>
    <Dialog v-model:visible="dialogOpen">
        <form @submit.prevent="driverExceptionSubmit">
            <label for="dateStart">Date Start</label>
            <PrimeVueCalendar id="dateStart" v-model="driverExceptionForm.date_start"></PrimeVueCalendar>
            <label for="dateEnd">Date End</label>
            <PrimeVueCalendar id="dateEnd" v-model="driverExceptionForm.date_end"></PrimeVueCalendar>
            <label for="dateNotes">Notes</label>
            <Textarea id="dateNotes" v-model="driverExceptionForm.notes"></Textarea>
            <Button type="submit">Submit</Button>
        </form>
    </Dialog>
    <Calendar :events="exceptions" :onSelectCallback="dateSelectCallback"></Calendar>
</template>