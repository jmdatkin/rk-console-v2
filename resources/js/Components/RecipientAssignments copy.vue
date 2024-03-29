<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import WeekdayAssignButton from '@/Components/Assignments/WeekdayAssignButton';
import { FilterMatchMode} from 'primevue/api';
import { useToast } from 'primevue/usetoast';
import { onMounted, ref } from 'vue';

const props = defineProps(['recipientData'])
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

const recipientFilters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const clearFilters = function () {
    recipientFilters.value = {
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
};


const selectedWeekday = ref();
const recipientDialogOpen = ref(false);
const recipientData = ref([]);
const recipientDataLoaded = ref(false);

const getRecipientData = function () {
    axios.get('/recipient')
        .then(res => {
            recipientData.value = res.data;
            recipientDataLoaded.value = true;
        }).catch(err => console.error(err));
};

const createSelectCallback = function (day) {
    return function () {
        selectedWeekday.value = day;
        recipientDialogOpen.value = true;
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
    getRouteData();
    getData();
})

</script>

<template>
    <Dialog :modal="true" :dismissableMask="true" :closeOnEscape="true" v-model:visible="recipientDialogOpen">
        <template #header>
            {{ WEEKDAYS[selectedWeekday] }}
        </template>
        <DataTable v-if="recipientDataLoaded" :value="recipientData" :paginator="true" :rows="10"
            v-model:selection="selectedRoute" v-model:filters="recipientFilters" selectionMode="single" dataKey="id"
            @row-select="submitAssignment(selectedRoute, selectedWeekday)">
            <template #header>
                <div class="flex justify-content-between">
                    <Button type="button" icon="pi pi-filter-slash" label="Clear" class="p-button-outlined"
                        @click="clearFilters()" />
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText v-model="recipientFilters['global'].value" placeholder="Search" />
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