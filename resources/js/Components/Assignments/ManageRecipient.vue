<script setup>
import AssignmentLayout from '@/Layouts/AssignmentLayout';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import WeekView from '@/Components/WeekView';
import Weekday from '@/Components/Weekday';
import OverlayPanel from 'primevue/overlaypanel';
import Dialog from 'primevue/dialog';
import DataTable from 'primevue/datatable';
import Button from 'primevue/button';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { Inertia, onSuccess } from '@inertiajs/inertia';

import { ref, reactive, computed, onUpdated, onMounted } from 'vue';

const toast = useToast();
const props = defineProps(['assignment_data', 'recipient_id', 'recipientData', 'message']);

const recipientData = ref(null);
const dataLoaded = ref(false);

const assignmentData = ref(props.assignment_data);
const assignmentDataLoaded = ref(false);

const routeData = ref(null);
const routeDataLoaded = ref(false);
const selectedRoute = ref();

const routeSelectOpen = ref(false);
const weekdaySelected = ref();

const routeFilters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const clearFilters = function () {
    routeFilters.value = {
        'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};

const makeWeekdayCallback = function (day) {
    return function () {
        weekdaySelected.value = day;
        routeSelectOpen.value = true;
    };
};

const weekdayFullName = function (abbr) {
    return {
        'sun': 'Sunday',
        'mon': 'Monday',
        'tue': 'Tuesday',
        'wed': 'Wednesday',
        'thu': 'Thursday',
        'fri': 'Friday',
        'sat': 'Saturday'
    }[abbr];
};

const submitRecipientAssignment = function (day) {
    Inertia.visit(`/manage/recipient/${props.recipient_id}/assign/${selectedRoute.value.id}/${weekdaySelected.value}`,
        {
            method: 'post',
            onFinish: page => {
                getAssignmentData();
            },
        });
};

const assignmentsForDay = function (day) {
    return assignmentData.value.filter(item => item.pivot.weekday === day).map(item => {
        return { id: item.id, name: item.name, notes: item.notes }
    });
};

axios.get(`/recipient/${props.recipient_id}`)
    .then(res => {
        recipientData.value = res.data;
        dataLoaded.value = true;
    }).catch(err => {
        console.error(err);
    });

const getAssignmentData = function () {
    assignmentDataLoaded.value = false;
    axios.get(`/manage/recipient/${props.recipient_id}/assignments`)
        .then(res => {
            assignmentData.value = res.data;
            assignmentDataLoaded.value = true;
        }).catch(err => console.error(err));
};

axios.get('/route')
    .then(res => {
        routeData.value = res.data;
        routeDataLoaded.value = true;
    }).catch(err => console.error(err));

onMounted(() => {
    // toast.add({ severity: props.message.class, summary: props.message.class === 'success' ? 'Successful' : 'Error', detail: props.message.detail, life: 3000 });
    getAssignmentData();
})

onUpdated(() => {
});
</script>


<template>
    <div>
        <Dialog v-model:visible="routeSelectOpen">
            <template #header>
                {{ weekdayFullName(weekdaySelected) }}
            </template>
            <DataTable v-if="routeDataLoaded" :value="routeData" :paginator="true" :rows="10"
                v-model:selection="selectedRoute" v-model:filters="routeFilters" selectionMode="single" dataKey="id"
                @row-select="submitRecipientAssignment(selectedRoute)">
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
                <!-- <Column field="notes" header="Notes"></Column> -->
            </DataTable>
        </Dialog>
        <WeekView v-if="assignmentDataLoaded">
            <template #header>
                Route assignments for {{ recipientData.person.firstName }} {{ recipientData.person.lastName }}
            </template>
            <Weekday :callback="makeWeekdayCallback('sun')" :data="assignmentsForDay('sun')">
                <template #head>
                    Sunday
                </template>
            </Weekday>
            <Weekday :callback="makeWeekdayCallback('mon')" :data="assignmentsForDay('mon')">
                <template #head>
                    Monday
                </template>

            </Weekday>
            <Weekday :callback="makeWeekdayCallback('tue')" :data="assignmentsForDay('tues')">
                <template #head>
                    Tuesday
                </template>

            </Weekday>
            <Weekday :callback="makeWeekdayCallback('wed')" :data="assignmentsForDay('wed')">
                <template #head>
                    Wednesday
                </template>

            </Weekday>
            <Weekday :callback="makeWeekdayCallback('thu')" :data="assignmentsForDay('thurs')">
                <template #head>
                    Thursday
                </template>

            </Weekday>
            <Weekday :callback="makeWeekdayCallback('fri')" :data="assignmentsForDay('fri')">
                <template #head>
                    Friday
                </template>

            </Weekday>
            <Weekday :callback="makeWeekdayCallback('sat')" :data="assignmentsForDay('sat')">
                <template #head>
                    Saturday
                </template>

            </Weekday>
        </WeekView>


    </div>
</template>

<style scoped lang="scss">
</style>