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
import { useConfirm } from 'primevue/useconfirm';
import { ref, onUpdated, onMounted, computed } from 'vue';

const props = defineProps(['onRowSelect', 'selection', 'date', 'openDateSelect', 'value', 'getData']);
const weekday = computed(() => {
    // return formatDate(props.date, { weekday: 'short' }).toLowerCase();
    return moment(props.date).format('ddd').toLowerCase();
});

const rowClass = (data) => {
    return data.inException ? 'in-exception' : null;
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

const selectedRoute = ref();
const openAlternateDriversDialog = function (routeData) {
    selectedRoute.value = routeData;
    getAlternateDriversData(routeData.id);
};

const altDriverDialog = ref(false);
const altDriverSelection = ref();
const altDriverData = ref([]);
const altDriverDataLoaded = ref(false);

const getAlternateDriversData = function (id) {
    axios.get(`/route/${id}/alternates`)
        .then(res => {
            altDriverData.value = res.data;
            altDriverDataLoaded.value = true;
            altDriverDialog.value = true;
        });
};

const switchDriverAssignment = function (routeId, driverId) {
    confirm.require({
        message: `Are you sure you want to assign driver '${driverId}' to route '${routeId}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-info',
        accept: () => {
            axios.post(`/driver/${driverId}/assign/${routeId}?weekday=${weekday.value}`)
                .then(() => props.getData());
        },
    });
};

</script>
<template>
    <Dialog v-model:visible="altDriverDialog" :closeOnEscape="true" :closable="true" :dismissableMask="true"
        :modal="true" :breakpoints="{
            '960px': '75vw',
            '640px': '100vw'
        }" :style="{ width: '50vw' }">
        <template #header><strong>Alternate Drivers for Route: {{ selectedRoute.name }}</strong></template>
        <DataTable @rowSelect="(event) => switchDriverAssignment(selectedRoute.id, event.data.id)" v-model:selection="altDriverSelection" selectionMode="single" :value="altDriverData">
            <Column header="id" field="id">
            </Column>
            <Column header="firstName" field="person.firstName">
                <template #body="{ data }">
                    <a @click="() => switchDriverAssignment(selectedRoute.id, data.id)">{{ data.person.firstName }}</a>
                </template>
            </Column>
            <Column header="lastName" field="person.lastName">
            </Column>
        </DataTable>
    </Dialog>
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
</style>