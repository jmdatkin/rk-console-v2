<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { formatDate } from '@fullcalendar/common';
import { ref, onUpdated, onMounted, computed } from 'vue';

const props = defineProps(['date', 'openDateSelect']);

const data = ref([]);
const tableData = computed(() => {
    return data.value.map(route => {
        return {
            name: route.name,
            driver: route.drivers[0] || {}
        };
    });
});


const getData = function () {
    axios.get('/routedriver/data?weekday=' + formatDate(props.date, {
        weekday: 'short'
        // month: '2-digit',
        // year: 'numeric',
        // day: 'numeric'
    }).toLowerCase())
        .then(res => {
            data.value = res.data;
        });
};

onMounted(() => {
    console.log('updated');
    getData();
});

</script>
<template>
<DataTable :value="tableData">
    <Column header="Route" field="name">
    </Column>
    <Column header="Driver" field="driver.person.firstName">
    </Column>
</DataTable>
    <!-- <div v-for="route in data">
        {{ route.name }}
        <span v-if="route.drivers[0]">
            {{ `${route.drivers[0].person.firstName} ${route.drivers[0].person.lastName}` }}
        </span>
        <hr>
    </div> -->
    {{ tableData }}
    <!-- {{ data }} -->
    <!-- <DataTable :value="data">
</DataTable> -->
</template>