<script setup>
import RouteDriverTable from './RouteDriverTable';
import DriverExceptionList from './DriverExceptionList';
import AlternateDriversDataTable from '../../Components/DataTables/AlternateDriversDataTable';
import Dialog from 'primevue/dialog';
import Panel from 'primevue/panel';
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

const showExceptions = ref(false);
const selectedDriver = ref(null);
const onRowSelect = function (row) {
    console.log(row);
    selectedDriver.value = row;
    showExceptions.value = true;
};

const tableData = computed(() => {
    return data.value.map(row => {
        let isSub = false,
            inException = false;

        let routeId = row.id;

        let driver = {};
        let exception = {};
        let substitute;

        if (row.drivers.length > 0) {
            driver = row.drivers[0];

            if (driver.exceptions.length > 0) {
                inException = true;
                exception = driver.exceptions[0];

                if (typeof exception.substitutes !== 'undefined' && exception.substitutes.length > 0) {
                    substitute = exception.substitutes[0];

                    if (substitute.substitute.route_id === routeId) {
                        driver = substitute;
                        isSub = true;
                    }


                }

            }
        }

        return {
            driver,
            isSub,
            inException,
            routeId: row.id,
            routeName: row.name,
            ...row
        };
    });
});

const confirm = useConfirm();

const selectedException = ref();
const onExceptionSelect = function (exception) {
    console.log(exception);
    selectedException.value = exception;
    selectedRoute.value = exception.routeId;
    getAlternateDriversData(exception.routeId);
};

const selectedRoute = ref();

const altDriverDialog = ref(false);
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
        <AlternateDriversDataTable :data="altDriverData"
            :onSelect="(event) => assignSub(selectedException.id, event.data.id, selectedRoute.value)">
        </AlternateDriversDataTable>
    </Dialog>
    <div class="grid">
        <div :class="{ 'col-12': true, 'sm:col-8': showExceptions }">
            <RouteDriverTable :onRowSelect="onRowSelect" v-model:selection="selectedDriver" :date="date"
                :openDateSelect="openDateSelect" :value="tableData" :getData="getData"></RouteDriverTable>
        </div>
        <div v-show="showExceptions" class="col-12 sm:col-4">
            <Panel header="Exceptions">
                <template #icons>
                    <button class="p-panel-header-icon p-link mr-2" @click="() => showExceptions = false">
                        <span class="pi pi-times"></span>
                    </button>
                </template>
                <DriverExceptionList v-if="selectedDriver" :onExceptionSelect="onExceptionSelect"
                    :selectedDriver="selectedDriver"></DriverExceptionList>
            </Panel>
        </div>
    </div>

</template>