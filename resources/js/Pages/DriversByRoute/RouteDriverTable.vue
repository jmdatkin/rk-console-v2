<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Button from 'primevue/button';
import Row from 'primevue/row';
import Dialog from 'primevue/dialog';
import ContextMenu from 'primevue/contextmenu';
import moment from 'moment';
import { formatDate } from '@fullcalendar/common';
import { ref, onUpdated, onMounted, computed } from 'vue';

const props = defineProps(['onRowSelect', 'selection', 'date', 'openDateSelect', 'value', 'getData']);

const rowClass = (data) => {
    return data.inException ? 'in-exception' : null;
};


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
    <DataTable @row-select="e => onRowSelect(e.data)" v-model:selection="selection" selectionMode="single" :value="value" :paginator="true" :rowClass="rowClass" :rows="10" responsiveLayout="scroll"
        columnResizeMode="fit" :showGridlines="true">
        <template #header>

            <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" />
            {{ date }}
        </template>
        <ColumnGroup type="header">
            <Row>
                <Column header="Route" field="name" :rowspan="2">
                </Column>
                <Column header="Driver" :colspan="3">
                </Column>
            </Row>
            <Row>
                <Column header="id" field="driver.id"></Column>
                <Column header="First Name" field="firstName"></Column>
                <Column header="Last Name" field="lastName"></Column>
            </Row>
        </ColumnGroup>
        <Column header="Route" field="name">
        </Column>
        <Column :sortable="true" field="driver.id" header="id" style="max-width: 10%; text-align: center">
            <template #body="{ data }">
                {{ data.driver.id || '' }}
            </template>
            <template #filter="{ filterModel }">
                <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by id">
                </InputText>
            </template>
        </Column>
        <Column :sortable="true" field="firstName">
            <template #body="{ data }">
                <a :class="rowClass(data)" @click="() => openAlternateDriversDialog(data)">
                    {{ data.firstName }}
                </a>
            </template>
        </Column>
        <Column :sortable="true" field="lastName">
            <template #body="{ data }">
                <a @click="() => openAlternateDriversDialog(data)">
                    {{ data.lastName }}
                </a>
            </template>
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

.in-exception {
    // color: var(--red-800);
}


::v-deep .in-exception {
    background-color: var(--red-200) !important;
}


::v-deep .p-datatable .p-datatable-tbody tr.in-exception:focus {
    outline-color: var(--red-800) !important;
}

::v-deep .in-exception.p-highlight {
    outline-color: var(--red-800) !important;
}
</style>