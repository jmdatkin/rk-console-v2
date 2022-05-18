<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Calendar from '@/Components/Calendar';
import { ref, onMounted, computed } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { mergePersonObject } from '@/util';

const props = defineProps(['data']);

const dataXform = computed(() => props.data.map(mergePersonObject));

const filters = ref({
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'firstName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'lastName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'email':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneHome':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneCell':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'numMeals':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'notes':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },
});


const initFilters = function () {
    filters.value = {
        'global':
        {
            value: null, matchMode: FilterMatchMode.CONTAINS
        },

        'id':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        },

        'firstName':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        },

        'lastName':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        },

        'email':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },

        'phoneHome':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },

        'phoneCell':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },

        'notes':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },

    }
};

const dayLookup = {
    0: 'sun',
    1: 'mon',
    2: 'tues',
    3: 'wed',
    4: 'thurs',
    5: 'fri',
    6: 'sat'
};

const selectedDate = ref(null);
const isDateSelected = ref(false);

const selectDateCallback = function (date) {
    selectedDate.value = date.start;
    isDateSelected.value = true;
    getRecipientData();
    console.log(date);
};

const openDateSelection = function () {
    isDateSelected.value = false;
};

const recipientData = ref();
const recipientDataLoaded = ref(false);

const getRecipientData = function () {
    let weekday = dayLookup[selectedDate.value.getDay()];
    recipientDataLoaded.value = false;
    axios.get('/reports/meals/data?weekday='+weekday)
        .then((res) => {
            // recipientData.value = res.data.map(mergePersonObject);
            // recipientDataLoaded.value = true;
            recipientData.value = res.data;
            recipientDataLoaded.value = true;
        });
};

onMounted(() => {
    initFilters();
});
</script>

<template>
    <ReportLayout>
        <template #header>
            Meal Report
        </template>
        <template #report>
            <Button @click="openDateSelection">Choose Date</Button>
            <Calendar v-if="!isDateSelected && !assignmentDataLoaded" :onSelectCallback="selectDateCallback">
            </Calendar>

            <DataTable v-else :value="recipientData" :paginator="true" :rows="10" class="p-datatable-recipients"
                :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'phoneHome', 'phoneCell', 'numMeals', 'notes']"
                filterDisplay="menu" responsiveLayout="scroll" editMode="row" showGridlines :resizableColumns="true"
                columnResizeMode="fit" v-model:filters="filters" v-model:editingRows="editingRows"
                @row-edit-save="onRowEditSave" v-model:selection="selected">
                <template #header>
                    {{ selectedDate.toDateString() }}
                    <Toolbar class="p-0">
                        <template #start>
                            <Loading :show="!dataLoaded"></Loading>
                        </template>
                        <template #end>
                            <span class="p-input-icon-left ">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global'].value" placeholder="Search all columns" />
                            </span>

                        </template>

                    </Toolbar>

                </template>
                <template #loading>
                    Loading records, please wait...
                </template>
                <template #empty>
                    No records found.
                </template>

                <Column :sortable="true" field="routeName" header="Route Name" >
                    <template #body="{ data }">
                        {{ data.routeName }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by route name"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="aggNumMeals" header="Total Num. Meals">
                    <template #body="{ data }">
                        {{ data.aggNumMeals }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by num. meals"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
           
                <!-- <template #groupheader="slotProps">
                    <span class="font-medium">{{ slotProps.data.routeName }}</span>
                </template>
                <template #groupfooter="slotProps">
                </template> -->
            </DataTable>
        </template>
    </ReportLayout>
</template>