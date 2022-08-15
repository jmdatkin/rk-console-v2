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
import { ref, onUpdated, onMounted, computed } from 'vue';
import { driversByRouteFilters } from '@/filters';
import { DateAdapter } from '../../util';
import DriverExceptionList from './DriverExceptionList.vue';
import { useData } from '../../hooks';
import AlternateDriversDataTable from '../DataTables/AlternateDriversDataTable.vue';
import { useConfirm } from 'primevue/useconfirm';
import DriverSubInfo from '../DriverSubInfo.vue';

const props = defineProps(['date', 'data']);

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
    return props.data.map(row => {
        let isSub = row.substitute_drivers.length > 0;
        let driver;

        if (isSub) {
            driver = row.substitute_drivers[0];
        } else {
            driver = row.drivers[0];
        }

        return {driver, isSub, ...row};
    });
});

// const tableData = computed(() => {
//     return props.data.map(row => {
//         let isSub = false,
//             inException = false;

//         let routeId = row.id;

//         let driver = {};
//         let originalDriver;
//         let exception = {};
//         let substitute;

//         if (row.drivers.length > 0) {
//             driver = row.drivers[0];
//             originalDriver = driver;

//             if (driver.exceptions.length > 0) {
//                 inException = true;
//                 exception = driver.exceptions[0];

//                 if (typeof exception.substitutes !== 'undefined' && exception.substitutes.length > 0) {
//                     // substitute = exception.substitutes[0];
//                     substitute = exception.substitutes.find(val => val.substitute.route_id === routeId);

//                     if (substitute) {
//                         driver = substitute;
//                         isSub = true;
//                     }




//                 }

//             }
//         }

//         return {
//             originalDriver, 
//             driver,
//             substitute,
//             exception,
//             isSub,
//             inException,
//             routeId: row.id,
//             routeName: row.name,
//             ...row
//         };
//     });
// });

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
            <AlternateDriversDataTable :data="altDrivers" :onSelect="(event) => assignSub(selectedException.id, event.data.id, selectedRoute.value)">
            </AlternateDriversDataTable>
    </Dialog>
    <DataTable @row-select="e => onRowSelect(e.data)" v-model:selection="selection" selectionMode="single"
        :globalFilterFields="['routeName', 'id', 'driver.person.firstName', 'lastName']" filterDisplay="menu"
        v-model:filters="filters" :value="tableData" :paginator="true" :rowClass="rowClass" :rows="10"
        responsiveLayout="scroll" columnResizeMode="fit" :showGridlines="true">
        <template #header>
            {{ DateAdapter.format(date) }}
        </template>
        <ColumnGroup type="header">
            <Row>
                <Column header="Route" :colspan="2">
                </Column>
                <Column header="Driver" :colspan="3">
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
                <Column :sortable="true" header="Name" field="name">
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                </Column>
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
        <Column header="id" field="id">
        </Column>
        <Column header="Name" field="name">
        </Column>
        <Column :sortable="true" field="driver.id" header="id" style="max-width: 10%; text-align: center">
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