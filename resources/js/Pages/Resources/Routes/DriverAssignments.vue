<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Divider from 'primevue/divider';
import WeekdayAssignButton from '@/Components/Assignments/WeekdayAssignButton';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['routeData'])
const toast = useToast();

const WEEKDAYS = ref({
    'sun': 'Sunday',
    'mon': 'Monday',
    'tue': 'Tuesday',
    'wed': 'Wednesday',
    'thu': 'Thursday',
    'fri': 'Friday',
    'sat': 'Saturday'
});

const routeFilters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const clearFilters = function () {
    routeFilters.value = {
        'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};

const data = ref([]);
const dataLoaded = ref(false);

const getData = function () {
    dataLoaded.value = false;
    axios.get(route('route.drivers', { id: props.routeData.id }))
        .then(
            res => {
                data.value = res.data;
                dataLoaded.value = true;
            }
        );
};

const dataForDay = function (day) {
    return data.value.filter(item => item.pivot.weekday === day);//.map(item => {
    // return { id: item.id, name: item.name, notes: item.notes }
    // });
};


const selectedWeekday = ref();
const routeDialogOpen = ref(false);
const driverData = ref([]);
const driverDataLoaded = ref(false);

const getDriverData = function () {
    axios.get('/driver')
        .then(res => {
            driverData.value = res.data;
            driverDataLoaded.value = true;
        }).catch(err => console.error(err));
};

const createSelectCallback = function (day) {
    return function () {
        selectedWeekday.value = day;
        driverDialogOpen.value = true;
    };
};

const submitAssignment = function (driver_id, weekday) {
    axios.patch(route('route.assign', { route_id: props.routeData.id, driver_id, weekday }))
        .then(
            () => {
                getData();
                toast.add({ severity: 'success', summary: 'Successful', detail: 'Successfully assigned driver to route.', life: 3000 });
            },
            () => {
                toast.add({ severity: 'error', summary: 'Error', detail: 'An error occurred. Driver was not successfully assigned to route.', life: 3000 });
            }
        )
};

onMounted(() => {
    getDriverData();
    getData();
})

</script>

<template>
    <Dialog v-model:visible="routeDialogOpen">
        <template #header>
            {{ WEEKDAYS[selectedWeekday] }}
        </template>
        <DataTable v-if="routeDataLoaded" :value="routeData" :paginator="true" :rows="10"
            v-model:selection="selectedRoute" v-model:filters="routeFilters" selectionMode="single" dataKey="id"
            @row-select="submitAssignment(selectedRoute, selectedWeekday)">
            <template #header>
                <div class="flex justify-content-between">
                    <Button type="button" icon="pi pi-filter-slash" label="Clear" class="p-button-outlined"
                        @click="clearFilters()" />
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="routeFilters['global'].value" placeholder="Search" />
                    </span>
                </div>
            </template>
            <template #empty>
                No records found.
            </template>
            <Column field="id" header="id"></Column>
            <Column field="name" header="Name"></Column>
        </DataTable>
    </Dialog>
    <div class="flex flex-col">
        <template v-for="(fullName, weekday, index) in WEEKDAYS" :key="index">
            <WeekdayAssignButton class="mb-2" :title="fullName" :onSelect="createSelectCallback(weekday)"
                :data="dataForDay(weekday)">
            </WeekdayAssignButton>
            <!-- <Divider /> -->
        </template>
    </div>
</template>

<style lang="scss">
</style>