<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Button from 'primevue/button';
import Row from 'primevue/row';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import ContextMenu from 'primevue/contextmenu';
import moment from 'moment';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { formatDate } from '@fullcalendar/common';
import { ref, onUpdated, onMounted, computed } from 'vue';
import { driversByRouteFilters } from '../Resources/filters';

const props = defineProps(['onRowSelect', 'selection', 'date', 'openDateSelect', 'value']);

const filters = ref(driversByRouteFilters);
const initFilters = function () {
    filters.value = driversByRouteFilters;
};

const rowClass = (data) => {
    let classString = '';

    if (data.inException)
        classString += 'in-exception ';

    if (data.isSub)
        classString += 'is-sub ';

    return classString;
    // return data.inException ? 'in-exception' : null;

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
    <DataTable @row-select="e => onRowSelect(e.data)" v-model:selection="selection" selectionMode="single"
        :globalFilterFields="['routeName', 'id', 'driver.person.firstName', 'lastName']" filterDisplay="menu"
        v-model:filters="filters" :value="value" :paginator="true" :rowClass="rowClass" :rows="10"
        responsiveLayout="scroll" columnResizeMode="fit" :showGridlines="true">
        <template #header>

            <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" />
            {{ date }}
        </template>
        <ColumnGroup type="header">
            <Row>
                <Column :sortable="true" header="Route" field="routeName" :rowspan="2">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by route name">
                        </InputText>
                    </template>
                </Column>
                <Column header="Driver" :colspan="3">
                </Column>
            </Row>
            <Row>
                <Column :sortable="true" header="id" field="driver.id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" header="First Name" field="driver.person.firstName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by first name">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" header="Last Name" field="driver.person.lastName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by last name">
                        </InputText>
                    </template>
                </Column>
            </Row>
        </ColumnGroup>
        <Column header="Route" field="routeName">
        </Column>
        <Column :sortable="true" field="driver.id" header="id" style="max-width: 10%; text-align: center">
            <template #body="{ data }">
                {{ data.driver.id || '' }}
            </template>
        </Column>
        <Column :sortable="true" field="driver.person.firstName">
        </Column>
        <Column :sortable="true" field="driver.person.lastName">
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


::v-deep .p-datatable .p-datatable-tbody tr.in-exception:focus {
    outline-color: var(--red-800) !important;
}

::v-deep .in-exception.p-highlight {
    outline-color: var(--red-800) !important;
}
</style>