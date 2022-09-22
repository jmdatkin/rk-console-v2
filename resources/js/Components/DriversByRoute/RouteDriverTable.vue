<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import InputText from 'primevue/inputtext';
import Dialog from 'primevue/dialog';
import ContextMenu from 'primevue/contextmenu';
import moment from 'moment';
import { ref, onUpdated, onMounted, computed } from 'vue';
import { driversByRouteFilters } from '@/filters';
import { DateAdapter } from '../../util';
import AlternateDriversDataTable from '../DataTables/AlternateDriversDataTable.vue';
import { useConfirm } from 'primevue/useconfirm';
import DriverSubInfo from '../DriverSubInfo.vue';

const props = defineProps(['date', 'data', 'settings']);

const filters = ref(driversByRouteFilters);
const initFilters = function () {
    filters.value = driversByRouteFilters;
};

const driverSubDialogOpen = ref(false);

const selected = ref(null);
const selectedException = ref(null);
const selectedRoute = ref(null);

const confirm = useConfirm();

const rowClass = (data) => {
    let classString = '';

    if (data.inException)
        classString += 'in-exception ';

    if (data.isSub)
        classString += 'is-sub ';

    return classString;
    // return data.inException ? 'in-exception' : null;

};

const altDriverDialog = ref(false);
const altDrivers = ref([]);
const altDriversLoaded = ref(false);

// const { altDrivers, altDriversLoaded, getAltDrivers} = useData('/route/')

const getAlternateDrivers = function (id) {
    axios.get(`/route/${id}/alternates`)
        .then(res => {
            altDrivers.value = res.data;
            altDriversLoaded.value = true;
            altDriverDialog.value = true;
        });
};

const tableData = computed(() => {
    // return props.data.map(row => {
    //     let isSub = row.substitute_drivers.length > 0;
    //     let driver;

    //     if (isSub) {
    //         driver = row.substitute_drivers[0];
    //     } else {
    //         driver = row.drivers[0];
    //     }

    //     return {driver, isSub, ...row};
    // });
    return props.data;
});

const onRowSelect = function (row) {
    // if (!row.driver) return;
    selected.value = row;
    // showExceptions.value = true;
    driverSubDialogOpen.value = true;
};

const onExceptionSelect = function (exception) {
    selectedException.value = exception;
    selectedRoute.value = exception.routeId;
    getAlternateDrivers(exception.routeId);
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

const assignSub = function (exceptionId, substituteDriverId, routeId) {
    confirm.require({
        message: `Are you sure you want to assign driver '${substituteDriverId}' as a substitute?`,//to route '${routeId}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-info',
        accept: () => {
            // axios.post(`/driver/${driverId}/assign/${routeId}?weekday=${weekday.value}`)
            axios.post(route('exception.sub', { exception_id: exceptionId, substitute_driver_id: substituteDriverId }), { route_id: selectedException.value.routeId, date: props.date })
                .then(() => {
                    getData();
                    selected.value = null;
                });
        },
    });
}

// console.log(props.settings['driversbyroute.num_sub_drivers'])
console.log(props);

// onMounted(() => getData());

</script>
<template>
    <Dialog v-model:visible="driverSubDialogOpen" :modal="true" :dismissableMask="true" :closeOnEscape="true">
        <template #header>
            &nbsp;
        </template>
        <DriverSubInfo :data="selected" :date="date"></DriverSubInfo>
        <!-- <DriverExceptionList :onExceptionSelect="onExceptionSelect" :selectedDriver="selected"></DriverExceptionList> -->
    </Dialog>
    <Dialog v-model:visible="altDriverDialog" :modal="true" :dismissableMask="true" :closeOnEscape="true">
        <AlternateDriversDataTable :data="altDrivers"
            :onSelect="(event) => assignSub(selectedException.id, event.data.id, selectedRoute.value)">
        </AlternateDriversDataTable>
    </Dialog>
    <DataTable @row-select="e => onRowSelect(e.data)" v-model:selection="selection" selectionMode="single"
        :globalFilterFields="['routeName', 'id', 'driver.person.firstName', 'lastName']" filterDisplay="menu"
        v-model:filters="filters" :value="tableData" :paginator="true" :rowClass="rowClass" :rows="10"
        dataKey="route_id"
        responsiveLayout="scroll" columnResizeMode="fit" :showGridlines="true">
        <!-- <template #header>
        :groupRowsBy="['route_id','route_name','driver_id','driver_firstName','driver_lastName']"
        :groupRowsBy="['route_id','route_name','driver_id','driver_firstName','driver_lastName']"
            <span v-if="date">
            {{ DateAdapter.format(date) }}
            </span>
        </template> -->
        <ColumnGroup type="header">
            <Row>
                <Column header="Route" :colspan="2">
                </Column>
                <Column header="Driver" :colspan="3">
                </Column>

                <!-- <template v-for="idx in $page.props.settings['driversbyroute.num_sub_drivers']">
                    <Column :header="`Sub. Driver ${idx}`" :colspan="3">
                    </Column>
                </template> -->

                <Column header="Sub. Driver 1" :colspan="3">
                </Column>
                <Column header="Sub. Driver 2" :colspan="3">
                </Column>
                <Column header="Sub. Driver 3" :colspan="3">
                </Column>
                <Column header="Sub. Driver 4" :colspan="3">
                </Column>
            </Row>
            <Row>
                <Column :sortable="true" header="id" field="route_id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" header="Name" field="route_name">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" header="id" field="driver_id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" header="First Name" field="driver_firstName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by first name">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" header="Last Name" field="driver_lastName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by last name">
                        </InputText>
                    </template>
                </Column>

                <!-- <template v-for="idx in $page.props.settings['driversbyroute.num_sub_drivers']">
                    <Column :sortable="true" header="id" :field="`sub_driver_${idx}_id`">
                        <template #filter="{ filterModel }">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                                placeholder="Search by id">
                            </InputText>
                        </template>
                    </Column>
                    <Column :sortable="true" header="First Name" :field="`sub_driver_${idx}_firstName`">
                        <template #filter="{ filterModel }">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                                placeholder="Search by first name">
                            </InputText>
                        </template>
                    </Column>
                    <Column :sortable="true" header="Last Name" :field="`sub_driver_${idx}_lastName`">
                        <template #filter="{ filterModel }">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                                placeholder="Search by last name">
                            </InputText>
                        </template>
                    </Column>
                </template> -->

                <Column :sortable="true" header="id" field="sub_driver_0_id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.id ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="First Name" field="sub_driver_0_firstName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by first name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.firstName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="Last Name" field="sub_driver_0_lastName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by last name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.lastName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="id" field="sub_driver_1_id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.id ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="First Name" field="sub_driver_1_firstName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by first name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.firstName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="Last Name" field="sub_driver_1_lastName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by last name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.lastName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="id" field="sub_driver_2_id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.id ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="First Name" field="sub_driver_2_firstName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by first name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.firstName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="Last Name" field="sub_driver_2_lastName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by last name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.lastName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="id" field="sub_driver_3_id">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.id ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="First Name" field="sub_driver_3_firstName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by first name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.firstName ?? ''}}
                    </template>
                </Column>
                <Column :sortable="true" header="Last Name" field="sub_driver_3_lastName">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by last name">
                        </InputText>
                    </template>
                    <template #body="{data}">
                        {{ data.lastName ?? ''}}
                    </template>
                </Column>
            </Row>
        </ColumnGroup>

        <Column header="id" field="route_id">
        </Column>
        <Column header="Name" field="route_name">
        </Column>
        <Column :sortable="true" field="driver_id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" field="driver_firstName" header="First Name">
        </Column>
        <Column :sortable="true" field="driver_lastName" header="Last Name">
        </Column>

        <!-- <template v-for="idx in $page.props.settings['driversbyroute.num_sub_drivers']">
            <Column :sortable="true" :field="`sub_driver_${idx}_id`" header="id"
                style="max-width: 10%; text-align: center">
            </Column>
            <Column :sortable="true" :field="`sub_driver_${idx}_firstName`">
            </Column>
            <Column :sortable="true" :field="`sub_driver_${idx}_lastName`">
            </Column>
        </template> -->

        <Column :sortable="true" field="sub_driver_0_id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" field="sub_driver_0_firstName">
        </Column>
        <Column :sortable="true" field="sub_driver_0_lastName">
        </Column>
        <Column :sortable="true" field="sub_driver_1_id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" field="sub_driver_1_firstName">
        </Column>
        <Column :sortable="true" field="sub_driver_1_lastName">
        </Column>
        <Column :sortable="true" field="sub_driver_2_id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" field="sub_driver_2_firstName">
        </Column>
        <Column :sortable="true" field="sub_driver_2_lastName">
        </Column>
        <Column :sortable="true" field="sub_driver_3_id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" field="sub_driver_3_firstName">
        </Column>
        <Column :sortable="true" field="sub_driver_3_lastName">
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
    background-color: var(--yellow-100) !important;
    color: var(--yellow-900) !important;
}


::v-deep .p-datatable .p-datatable-tbody tr.in-exception:focus {
    outline-color: var(--red-800) !important;
}

::v-deep .in-exception.p-highlight {
    outline-color: var(--red-800) !important;
}
</style>