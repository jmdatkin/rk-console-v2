<script setup>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import moment from 'moment';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['baseURL','date']);

const days = ref({});

moment.weekdays().forEach((day,idx) => {
    days.value[day] = moment(props.date, 'MM-DD-YYYY').day(idx);//.format('MM-DD-YYYY');
});

const visitDay = function(event) {
	let idx = event.index;
	Inertia.visit(`${props.baseURL}/${Object.values(days.value)[idx].format('MM-DD-YYYY')}`, { replace: true});
};

const activeIndex = ref(moment(props.date, 'MM-DD-YYYY').day());

</script>

<template>
<TabView scrollable @tab-click="visitDay" v-model:activeIndex="activeIndex">
	<!-- <TabPanel v-for="(dayName, day) in moment.weekdays()"
	:header="`dayName`"
	></TabPanel> -->
	<TabPanel v-for="(day, dayName) in days"
	:header="`${dayName} ${day.format('MM/DD')}`"
	></TabPanel>
</TabView>

</template>

<style lang="scss">
.p-tabview-panels {
	display: none;
}
</style>