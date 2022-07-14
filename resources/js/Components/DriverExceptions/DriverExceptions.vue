
<script setup>
import Calendar from '@/Components/Calendar';
import PrimeVueCalendar from 'primevue/calendar';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';
import { ref, reactive, computed, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

const props = defineProps(['driverData']);
const toast = useToast();

const exceptions = ref([]);
const getExceptions = function () {
    axios.get(route('exception.driver', { driver_id: props.driverData.id }))
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
    // Inertia.post('/exceptions/store', driverExceptionForm);
    axios.post(route('exception.store', driverExceptionForm))
        .then(
            () => {
                getExceptions();
                toast.add({ severity: 'success', summary: 'Successful', detail: 'Driver exception successfully created.', life: 3000 });
            },
            () => {
                toast.add({ severity: 'error', summary: 'Error', detail: 'An error occurred. Driver exception was not successfully created.', life: 3000 });
            }

        )
};

onMounted(() => {
    getExceptions();
});

</script>

<template>
    <Dialog v-model:visible="dialogOpen" :modal="true" :dismissableMask="true" :closeOnEscape="true" :breakpoints="{
        '960px': '75vw',
        '640px': '100vw'
    }" :style="{ width: '50vw' }">
        <template #header>
            {{ driverData.person.firstName }} {{ driverData.person.lastName }}
        </template>
        <form @submit.prevent="driverExceptionSubmit">
            <div class="grid">
                <div class="col-12">
                    <!-- <label for="dateStart">Date Start</label> -->
                    <h3>Date Start</h3>
                    <PrimeVueCalendar id="dateStart" v-model="driverExceptionForm.date_start"></PrimeVueCalendar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <h3>Date End</h3>
                    <PrimeVueCalendar id="dateEnd" v-model="driverExceptionForm.date_end"></PrimeVueCalendar>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <h3>Notes</h3>
                    <Textarea id="dateNotes" v-model="driverExceptionForm.notes"></Textarea>
                </div>
            </div>
            <div class="grid">
                <div class="col-12">
                    <Button type="submit">Submit</Button>
                </div>
            </div>
        </form>
    </Dialog>
    {{ driverData.person.firstName }} {{ driverData.person.lastName }}
    <Calendar :events="exceptions" :onSelectCallback="dateSelectCallback"></Calendar>
</template>