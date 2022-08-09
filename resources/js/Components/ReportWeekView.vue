<script setup>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import moment from 'moment';

const props = defineProps(['date', 'openDateSelect']);

const startOfWeek = moment(props.date).startOf('week');

const days = moment.weekdays.reduce((carry, weekday, idx) => {
	let obj = {};
	obj[weekday] = startOfWeek.clone().day(idx);
	return {obj, ...carry};
}, {});
</script>

<template>
<TabView scrollable>
	
	<TabPanel v-for="(dayName, day) in moment.weekdays()"
	header="weekday"
	@click="$emit('weekday-select', day)"
	></TabPanel>

</TabView>
</template>

<style lang="scss">
div.p-tabview-panels {
    display: none;
}

html div.p-tabview .p-tabview-nav li {
    flex-grow: 1;
}

html a.p-tabview-nav-link {
    // text-align: center;
    place-content: center;
}
</style>