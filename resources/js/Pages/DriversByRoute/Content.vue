<script setup>
import RouteDriverTable from './RouteDriverTable';
import DriverExceptionList from './DriverExceptionList';
import moment from 'moment-timezone';
import { formatDate } from '@fullcalendar/common';
import { ref, onMounted, computed } from 'vue';
import { useConfirm } from 'primevue/useconfirm';
import { DateAdapter } from '../../util';

const props = defineProps(['date', 'openDateSelect']);

const weekday = computed(() => {
    return moment(props.date).format('ddd').toLowerCase();
});

const data = ref([]);
const getData = function () {
    let dateString = DateAdapter.make(props.date);

    // axios.get('/routedriver/data?date=' + dateString)
    axios.get(route('driversbyroute.data', { date: dateString }))
        .then(res => {
            data.value = res.data;
        });
};

const selectedDriver = ref(null);
const onRowSelect = function (row) {
    selectedDriver.value = row;
};

const tableData = computed(() => {
    return data.value.map(route => {
        let isDriver = typeof route.drivers[0] !== 'undefined';
        let driver = route.drivers[0] || {};
        return {
            id: route.id,
            name: route.name,
            firstName: isDriver ? driver.person.firstName : '',
            lastName: isDriver ? driver.person.lastName : '',
            driver: isDriver ? route.drivers[0] : {},
            exceptions: isDriver ? route.drivers[0].exceptions : [],
            inException: isDriver ? route.drivers[0].exceptions.reduce((prev, curr) => {
                console.log(curr.date_start);
                return prev || moment(props.date).isBetween(curr.date_start, curr.date_end);
            }, false) : false
        };
    });
});

const confirm = useConfirm();

const selectedException = ref();
const onExceptionSelect = function(exception) {
    selectedException.value = exception;
    openAlternateDriversDialog(exception);
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

// const switchDriverAssignment = function (routeId, driverId) {
//     confirm.require({
//         message: `Are you sure you want to assign driver '${driverId}' to route '${routeId}?`,
//         icon: 'pi pi-exclamation-triangle',
//         acceptClass: 'p-button-info',
//         accept: () => {
//             axios.post(`/driver/${driverId}/assign/${routeId}?weekday=${weekday.value}`)
//                 .then(() => props.getData());
//         },
//     });
// };
const assignSub = function (exceptionId, substituteDriverId) {
    confirm.require({
        message: `Are you sure you want to assign driver '${driverId}' to route '${routeId}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-info',
        accept: () => {
            // axios.post(`/driver/${driverId}/assign/${routeId}?weekday=${weekday.value}`)
            axios.post(route('exception.sub', { exception_id: exceptionId, substitute_driver_id: substituteDriverId }))
                .then(() => {
                    getData();
                    selectedDriver.value = null;
                });
        },
    });
}

onMounted(() => {
    getData();
});
</script>

<template>
    <Dialog v-model:visible="altDriverDialog" :closeOnEscape="true" :closable="true" :dismissableMask="true"
        :modal="true" :breakpoints="{
            '960px': '75vw',
            '640px': '100vw'
        }" :style="{ width: '50vw' }">
        <template #header><strong>Alternate Drivers for Route: {{ selectedRoute.name }}</strong></template>
        <DataTable @rowSelect="(event) => switchDriverAssignment(selectedRoute.id, event.data.id)"
            v-model:selection="altDriverSelection" selectionMode="single" :value="altDriverData">
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
    <div class="grid">
        <div class="col-12 sm:col-8">
            <RouteDriverTable :onRowSelect="onRowSelect" v-model:selection="selectedDriver" :date="date"
                :openDateSelect="openDateSelect" :value="tableData" :getData="getData"></RouteDriverTable>
        </div>
        <div class="col-12 sm:col-4">
            <h3>Exceptions</h3>
            <DriverExceptionList v-if="selectedDriver" :onExceptionSelect="onExceptionSelect" :exceptions="selectedDriver.exceptions"></DriverExceptionList>
        </div>
    </div>

</template>