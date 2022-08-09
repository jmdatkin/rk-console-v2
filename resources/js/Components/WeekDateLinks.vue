<script setup>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import moment from 'moment';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['baseURL','date']);

const days = ref({});

moment.weekdays().forEach((day,idx) => {
    days.value[day] = moment(props.date).day(idx).format('MM-DD-YYYY');
});

const visitDay = function(event) {
	let idx = event.index;
	Inertia.visit(`${props.baseURL}/${Object.values(days.value)[idx]}`, { replace: true});
};

const activeIndex = ref(moment(props.date).day());

</script>

<template>
<TabView scrollable @tab-click="visitDay" v-model:activeIndex="activeIndex">
	<TabPanel v-for="(dayName, day) in moment.weekdays()"
	:header="dayName"
	></TabPanel>
</TabView>

</template>