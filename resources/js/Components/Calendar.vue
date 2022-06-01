<script setup>
import '@fullcalendar/core/vdom';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { ref } from 'vue';

const props = defineProps(['onSelectCallback', 'events']);

const calendarOptions = ref({
    plugins: [
        dayGridPlugin,
        interactionPlugin
    ],
    initialView: 'dayGridMonth',
    selectable: true,
    events: props.events, 
    eventDataTransform: function (eventData) {
        console.log(eventData);
        return {
            groupId: 1,
            start: eventData.date_start,
            end: eventData.date_end,
            title: eventData.notes,
            display: 'background',
            backgroundColor: 'red'
        };
    },
    select: props.onSelectCallback,
    // dateClick: () => console.log("EEEEEE")
});

</script>

<template>
    <FullCalendar :options="calendarOptions">

    </FullCalendar>
</template>

<style lang="scss" scoped>
.fc-bgevent {
    background-color: red;
}
</style>
