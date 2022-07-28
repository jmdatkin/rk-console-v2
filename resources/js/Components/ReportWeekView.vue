<script setup>
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import moment from 'moment';

const props = defineProps(['date', 'openDateSelect']);

const startOfWeek = moment(props.date).startOf('week');
</script>

<template>
<TabView scrollable>
	<TabPanel header="Sunday">
	</TabPanel>
	<TabPanel header="Monday">
	</TabPanel>
	<TabPanel header="Tuesday">
	</TabPanel>
	<TabPanel header="Wednesday">
	</TabPanel>
	<TabPanel header="Thursday">
	</TabPanel>
	<TabPanel header="Friday">
	</TabPanel>
	<TabPanel header="Saturday">
	</TabPanel>
</TabView>
</template>

<style lang="scss">
div.p-tabview-panels {
    display: none;
}

html div.p-tabview .p-tabview-nav li {
    flex-grow: 1;
}
</style>