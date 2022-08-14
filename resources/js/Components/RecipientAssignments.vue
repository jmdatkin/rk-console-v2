<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Divider from 'primevue/divider';
import WeekdayAssignments from './RecipientWeekdayAssignments';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';
import moment from 'moment';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['recipientData'])
const toast = useToast();

// const WEEKDAYS = ref({
//     'sun': 'Sunday',
//     'mon': 'Monday',
//     'tue': 'Tuesday',
//     'wed': 'Wednesday',
//     'thu': 'Thursday',
//     'fri': 'Friday',
//     'sat': 'Saturday'
// });
const WEEKDAYS = ref(moment.weekdays());

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
    axios.get(route('recipient.routes', { id: props.recipientData.id }))
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
    axios.patch(route('recipient.assign', { recipient_id: props.recipientData.id, route_id, weekday }))
        .then(
            () => {
                getData();
                toast.add({ severity: 'success', summary: 'Successful', detail: 'Successfully assigned recipient to route.', life: 3000 });
            },
            () => {
                toast.add({ severity: 'error', summary: 'Error', detail: 'An error occurred. recipient was not successfully assigned to route.', life: 3000 });
            }
        )
};

onMounted(() => {
    clearFilters();
    getRouteData();
    getData();
});

</script>

<template>
    <Dialog :modal="true" :dismissableMask="true" :closeOnEscape="true" v-model:visible="routeDialogOpen">
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
        <template v-for="(weekday, index) in WEEKDAYS" :key="index">
            <WeekdayAssignments class="mb-2" :getData="getData" :title="weekday" :onSelect="createSelectCallback(index)"
                :data="dataForDay(index)">
            </WeekdayAssignments>
            <!-- <Divider /> -->
        </template>
    </div>
</template>

<style lang="scss">
</style>