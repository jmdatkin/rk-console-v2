<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Button from 'primevue/button';
import Row from 'primevue/row';
import Dialog from 'primevue/dialog';
import ContextMenu from 'primevue/contextmenu';
import moment from 'moment';
import { useConfirm } from 'primevue/useconfirm';
import { ref, onUpdated, onMounted, computed } from 'vue';

const props = defineProps(['onSelect', 'selection', 'date', 'openDateSelect', 'value', 'getData']);

const tableData = computed(() => {
    return props.value.map(row => {
        let isSub = false,
            inException = false;
        let driver = row.drivers[0] || {};

        if (driver.subbed_by && driver.subbed_by.length > 0) {
            driver = driver.subbed_by[0];
            isSub = true;
        }

        if (driver.exceptions && driver.exceptions.length > 0) {
            inException = true;
        }
        
        return {
            driver,
            isSub,
            ...row
        };
    });
});

const rowClass = (data) => {
    return data.isSub ? 'is-sub' : ''
};

const confirm = useConfirm();

// Context menu
const cmSelection = ref();
const cm = ref();
const menuModel = ref([
    { label: 'Change driver', icon: 'pi pi-fw pi-pencil', command: () => editingRows.value = [...editingRows.value, cmSelection.value] },
    { label: 'Sub driver', icon: 'pi pi-fw pi-trash', command: () => destroyRecords([cmSelection.value.id]) },
]);
const onRowContextMenu = event => {
    cm.value.show(event.originalEvent);
};


</script>
<template>
    <DataTable @row-select="onSelect" v-model:selection="selection" selectionMode="single"
        :value="tableData" :paginator="true" :rowClass="rowClass" :rows="5" responsiveLayout="scroll"
        columnResizeMode="fit" :showGridlines="true"
        >
        <template #empty>
            No records found.
        </template>
        <ColumnGroup type="header">
            <Row>
                <Column header="Route" field="routeName" :rowspan="1" :colspan="2">
                </Column>
                <Column header="Driver" :colspan="6">
                </Column>
            </Row>
            <Row>
                <Column header="id" field="id"></Column>
                <Column header="Name" field="name"></Column>
                <Column header="id" field="driver.id"></Column>
                <Column header="First Name" field="driver.person.firstName"></Column>
                <Column header="Last Name" field="driver.person.lastName"></Column>
                <Column header="Email" field="driver.person.email"></Column>
                <Column header="Home Phone" field="driver.person.phoneHome"></Column>
                <Column header="Cell Phone" field="driver.person.phoneCell"></Column>
            </Row>
        </ColumnGroup>
        <Column header="id" field="id">
        </Column>
        <Column header="Route" field="name">
        </Column>
        <Column :sortable="true" field="driver.id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" field="driver.person.firstName">
        </Column>
        <Column :sortable="true" field="driver.person.lastName">
        </Column>
        <Column :sortable="true" field="driver.person.email">
        </Column>
        <Column :sortable="true" field="driver.person.phoneHome">
        </Column>
        <Column :sortable="true" field="driver.person.phoneCell">
        </Column>
    </DataTable>
    <ContextMenu :model="menuModel" ref="cm"></ContextMenu>
</template>

<style lang="scss" scoped>
a {
    cursor: pointer;
}

a:hover {
    text-decoration: underline;
}

::v-deep .in-exception {
    background-color: var(--red-200) !important;
}

::v-deep .is-sub {
    background-color: var(--yellow-300) !important;
    color: var(--yellow-900) !important;
}
</style>