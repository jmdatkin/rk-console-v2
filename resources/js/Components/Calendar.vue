<script setup>
import '@fullcalendar/core/vdom';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { ref } from 'vue';

const props = defineProps(['onSelectCallback']);

const calendarOptions = ref({
    plugins: [
        dayGridPlugin,
        interactionPlugin
    ],
    initialView: 'dayGridMonth',
    selectable: true,
    
    select: props.onSelectCallback,
    // dateClick: () => console.log("EEEEEE")
});

</script>

<template>
    <FullCalendar :options="calendarOptions">

    </FullCalendar>
</template>

<style lang="scss" scoped>

</style>
