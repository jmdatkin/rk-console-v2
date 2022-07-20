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
import { useData } from '../../../hooks';
import DateSelect from '../../../Components/DateSelect.vue';
import MealsReportTable from '../../../Components/MealsReport/MealsReportTable.vue';



const dataXform = computed(() => data.map(mergePersonObject));
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
    2: 'tue',
    3: 'wed',
    4: 'thu',
    5: 'fri',
    6: 'sat'
};

const selectedDate = ref(null);
const isDateSelected = ref(false);

onMounted(() => {
    initFilters();
});
</script>

<template>
    <ReportLayout>
        <template #title>
            Meal Report
        </template>
        <template #report>

            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <MealsReportTable :date="date" :openDateSelect="openDateSelect">
                    </MealsReportTable>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>