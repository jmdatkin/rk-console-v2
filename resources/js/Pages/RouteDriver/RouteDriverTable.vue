<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import Dialog from 'primevue/dialog';
import { formatDate } from '@fullcalendar/common';
import { useConfirm } from 'primevue/useconfirm';
import { ref, onUpdated, onMounted, computed } from 'vue';

const props = defineProps(['date', 'openDateSelect']);
const weekday = computed(() => {
    return formatDate(props.date, {weekday: 'short'}).toLowerCase();
});

const data = ref([]);
const getData = function () {
    console.log(weekday.value);
    axios.get('/routedriver/data?weekday='+weekday.value)
        .then(res => {
            data.value = res.data;
        });
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
            driver: isDriver ? route.drivers[0] : {}
        };
    });
});

const confirm = useConfirm();

const altDriverDialog = ref(false);
const selectedRoute = ref();
const openAlternateDriversDialog = function (routeData) {
    selectedRoute.value = routeData;
    getAlternateDriversData(routeData.id);
};

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

const switchDriverAssignment = function(routeId, driverId) {
    confirm.require({
        message: `Are you sure you want to assign driver '${driverId}' to route '${routeId}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-info',
        accept: () => {
            axios.post(`/driver/${driverId}/assign/${routeId}?weekday=${weekday.value}`)
            .then(() => getData());
        },
    });
};

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
        <DataTable :value="altDriverData">
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
    <DataTable :value="tableData" :paginator="true" :rows="10" responsiveLayout="scroll" columnResizeMode="fit"
        :showGridlines="true">
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
                <a @click="() => openAlternateDriversDialog(data)">
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
</template>

<style lang="scss" scoped>
a {
    cursor: pointer;
}

a:hover {
    text-decoration: underline;
}
</style>