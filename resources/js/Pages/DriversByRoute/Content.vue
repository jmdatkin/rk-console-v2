<script setup>
import RouteDriverTable from './RouteDriverTable';
import DriverExceptionList from './DriverExceptionList';
import moment from 'moment';
import { formatDate } from '@fullcalendar/common';
import { ref, onMounted, computed } from 'vue';
import { DateAdapter } from '../../util';

const props = defineProps(['date', 'openDateSelect']);

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

const exceptions = computed(() => {
    return tableData.value.reduce((prev, curr) => {
        return prev.concat(curr.exceptions);
    }, [])
        .filter(val => {
            return selectedDriver.value === null ? false : val.driver.id === selectedDriver.value.id;
        });
});

onMounted(() => {
    getData();
});
</script>

<template>
    <div class="grid">
        <div class="col-12 sm:col-8">
            <RouteDriverTable :onRowSelect="onRowSelect" v-model:selection="selectedDriver" :date="date"
                :openDateSelect="openDateSelect" :value="tableData" :getData="getData"></RouteDriverTable>
        </div>
        <div class="col-12 sm:col-4">
            <DriverExceptionList v-if="selectedDriver" :exceptions="selectedDriver.exceptions"></DriverExceptionList>
        </div>
    </div>

</template>