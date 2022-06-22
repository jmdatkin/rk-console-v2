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

const props = defineProps(['driverData'])
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
    axios.get(route('driver.routes', { id: props.driverData.id }))
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
const routeData = ref([]);
const routeDataLoaded = ref(false);

const getRouteData = function () {
    axios.get('/route')
        .then(res => {
            routeData.value = res.data;
            routeDataLoaded.value = true;
        }).catch(err => console.error(err));
};

const createSelectCallback = function (day) {
    return function () {
        selectedWeekday.value = day;
        routeDialogOpen.value = true;
    };
};

const submitAssignment = function (route_id, weekday) {
    axios.patch(route('driver.assign', { driver_id: props.driverData.id, route_id, weekday }))
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
    getRouteData();
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
            <WeekdayAssignButton :title="fullName" :onSelect="createSelectCallback(weekday)"
                :data="dataForDay(weekday)">
            </WeekdayAssignButton>
            <Divider />
        </template>
    </div>
</template>