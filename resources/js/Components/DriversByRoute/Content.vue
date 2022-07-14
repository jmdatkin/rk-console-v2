<script setup>
import RouteDriverTable from './RouteDriverTable';
import DriverExceptionList from './DriverExceptionList';
import AlternateDriversDataTable from '../../Components/DataTables/AlternateDriversDataTable';
import Dialog from 'primevue/dialog';
import Panel from 'primevue/panel';
import moment from 'moment-timezone';
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
    axios.get(route('driversbyroute.data', { date: dateString }))
        .then(res => {
            data.value = res.data;
        });
};


const tableData = computed(() => {
    return data.value.map(row => {
        let isSub = false,
            inException = false;

        let routeId = row.id;

        let driver = {};
        let originalDriver;
        let exception = {};
        let substitute;

        if (row.drivers.length > 0) {
            driver = row.drivers[0];
            originalDriver = driver;

            if (driver.exceptions.length > 0) {
                inException = true;
                exception = driver.exceptions[0];

                if (typeof exception.substitutes !== 'undefined' && exception.substitutes.length > 0) {
                    // substitute = exception.substitutes[0];
                    substitute = exception.substitutes.find(val => val.substitute.route_id === routeId);

                    if (substitute) {
                        driver = substitute;
                        isSub = true;
                    }




                }

            }
        }

        return {
            originalDriver, 
            driver,
            substitute,
            exception,
            isSub,
            inException,
            routeId: row.id,
            routeName: row.name,
            ...row
        };
    });
});

const confirm = useConfirm();

const selected = ref(null);
const onRowSelect = function (row) {
    selected.value = row;
    showExceptions.value = true;
};

const showExceptions = ref(false);
const showSubstitutes = ref(false);
const selectedException = ref();
const onExceptionSelect = function (exception) {
    selectedException.value = exception;
    selectedRoute.value = exception.routeId;
    getAlternateDrivers(exception.routeId);
};
const closeExceptionDialog = () => showExceptions.value = false;

const selectedRoute = ref();

const altDriverDialog = ref(false);
const altDriverData = ref([]);
const altDriverDataLoaded = ref(false);
const getAlternateDrivers = function (id) {
    axios.get(`/route/${id}/alternates`)
        .then(res => {
            altDriverData.value = res.data;
            altDriverDataLoaded.value = true;
            altDriverDialog.value = true;
        });
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
            <RouteDriverTable :onRowSelect="onRowSelect" v-model:selection="selected" :date="date"
                :openDateSelect="openDateSelect" :value="tableData"></RouteDriverTable>
        </div>
        <div v-show="showExceptions || showSubstitutes" class="col-12 sm:col-4">
            <Panel v-show="showExceptions" header="Exceptions">
                <template #icons>
                    <Button class="p-panel-header-icon p-link mr-2" @click="closeExceptionDialog">
                        <span class="pi pi-times"></span>
                    </Button>
                </template>
                <DriverExceptionList v-if="selected" :onExceptionSelect="onExceptionSelect"
                    :selectedDriver="selected"></DriverExceptionList>
            </Panel>
            <Panel v-show="showSubstitutes" header="Substitute">
                <template #icons>
                    <Button class="p-panel-header-icon p-link mr-2" @click="closeExceptionDialog">
                        <span class="pi pi-times"></span>
                    </Button>
                </template>
                
            </Panel>
        </div>
    </div>

</template>