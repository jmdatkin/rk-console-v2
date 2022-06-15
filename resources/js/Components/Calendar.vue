<script setup>
import '@fullcalendar/core/vdom';
import moment from 'moment';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import { onUpdated, ref } from 'vue';

const props = defineProps(['onSelectCallback', 'events', 'limitSelect']);

const calendar = ref();

const calendarOptions = ref({
    plugins: [
        dayGridPlugin,
        interactionPlugin
    ],
    initialView: 'dayGridMonth',
    contentHeight: 'auto',
    selectable: true,
    dayCellClassNames: function(arg) {
        let { date } = arg;
        if (!props.limitSelect) return [];
        if (moment().startOf('week').isAfter(date)) {
            return ['fc-before-current-week'];
        }
    },
    selectAllow: function (selectInfo) {
        if (!props.limitSelect) return true;
        return moment().startOf('week').isSameOrBefore(selectInfo.start);
    },
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
});

onUpdated(() => {
    calendarOptions.value.events = [...props.events];
});

</script>

<template>
    <FullCalendar ref="calendar" :options="calendarOptions">

    </FullCalendar>
</template>

<style lang="scss">
.fc-bgevent {
    background-color: red;
}

.fc-before-current-week {
    // background-color: #eee;
    background-color: var(--surface-100);
}
.p-submenu-list {
    background-color: red;
    z-index: 2 !important;
}
</style>
