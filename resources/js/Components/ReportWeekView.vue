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
<<<<<<< HEAD
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
=======
		<slot :date="startOfWeek"></slot>
	</TabPanel>
	<TabPanel header="Monday">
		<slot :date="startOfWeek.add(1,'day')"></slot>
	</TabPanel>
	<TabPanel header="Tuesday">
		<slot :date="startOfWeek.add(2,'day')"></slot>
	</TabPanel>
	<TabPanel header="Wednesday">
		<slot :date="startOfWeek.add(3,'day')"></slot>
	</TabPanel>
	<TabPanel header="Thursday">
		<slot :date="startOfWeek.add(4,'day')"></slot>
	</TabPanel>
	<TabPanel header="Friday">
		<slot :date="startOfWeek.add(5,'day')"></slot>
	</TabPanel>
	<TabPanel header="Saturday">
		<slot :date="startOfWeek.add(6,'day')"></slot>
>>>>>>> acb1551ecb4b69b9fabbb0018699e296a0379927
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