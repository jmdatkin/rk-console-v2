<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import AssignmentService from '@/Service/AssignmentService';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['data', 'onRowSelect']);

const onRowReorder = function (event) {
    let recipient = props.data[event.dragIndex]; // Recipient being dragged
    let recipient_id = recipient.id;
    let route_id = recipient.pivot.route_id;
    let weekday = recipient.pivot.weekday;
    AssignmentService.reorderRecipientAssignment(route_id, recipient_id, weekday, event.dropIndex)
    .then(
        () => Inertia.reload(),
        () => {}
    );
}
</script>

<template>
    <DataTable responsiveLayout="scroll" :value="data" @row-select="onRowSelect" dataKey="pivot.driver_custom_order"
        :sortOrder="1" sortField="pivot.driver_custom_order" @rowReorder="onRowReorder" selectionMode="single">
        <Column :rowReorder="true" headerStyle="width: 3rem" :reorderableColumn="false" />
        <Column field="id" header="id"></Column>
        <Column field="person.firstName" header="First"></Column>
        <Column field="person.lastName" header="Last"></Column>
        <Column field="address" header="Address"></Column>
        <Column field="numMeals" header="Num. Meals"></Column>
        <Column field="person.phoneHome" header="Home Phone"></Column>
        <Column field="person.phoneCell" header="Cell Phone"></Column>
        <Column field="person.notes" header="Notes"></Column>
    </DataTable>
</template>

<style lang="scss">
</style>