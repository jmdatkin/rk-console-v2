<script setup>
import ReportLayout from '@/Layouts/ReportLayout';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import Calendar from '@/Components/Calendar';
import InputText from 'primevue/inputtext';
import RecipientComments from '@/Components/RecipientComments';
import DriverReportDataTable from './DriverReportDataTable';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { ref, onMounted, computed } from 'vue';
import { mergePersonObject } from '@/util';

const props = defineProps(['driverData']);

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

    'address':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
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

        'address':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
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

const selectDateCallback = function (date) {
    selectedDate.value = date.start;
    isDateSelected.value = true;
    getData();
};

const openDateSelection = function () {
    isDateSelected.value = false;
};

const selectedRecipient = ref();
const commentsDialog = ref(false);

const openCommentsDialog = function (recipient) {
    selectedRecipient.value = recipient;
    commentsDialog.value = true;
};

const data = ref([]);
const dataLoaded = ref(false);


const getData = function () {
    let weekday = dayLookup[selectedDate.value.getDay()];
    dataLoaded.value = false;
    axios.get(`/reports/driver/data?weekday=${weekday}&driver_id=${props.driverData.id}`)
        .then((res) => {
            data.value = res.data.map(mergePersonObject);
            dataLoaded.value = true;
        });
};


onMounted(() => {
    initFilters();
});
</script>

<template>
    <ReportLayout>
        <Dialog 
        :style="{width: '50vw'}"
        :breakpoints="{
            '960px': '75vw',
            '640px': '100vw'
            }"
        v-model:visible="commentsDialog">
            <template #header>
                Comments for {{ selectedRecipient.firstName }} {{ selectedRecipient.lastName }}
            </template>
            <RecipientComments :driverId="props.driverData.id" :recipientId="selectedRecipient.id"></RecipientComments>
        </Dialog>
        <template #title>
            Driver Report
        </template>
        <template #header>
            <span>Driver: {{ driverData.person.firstName }} {{ driverData.person.lastName }}</span>
        </template>
        <template #report>
            <Button @click="openDateSelection">Choose Date</Button>
            <Calendar :onSelectCallback="selectDateCallback">
            </Calendar>

            <DataTable :value="data" :paginator="true" :rows="10" class="p-datatable-recipients"
                :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'address', 'phoneHome', 'phoneCell', 'numMeals', 'notes']"
                filterDisplay="menu" responsiveLayout="scroll" editMode="row" showGridlines :resizableColumns="true"
                groupRowsBy="routeName" rowGroupMode="subheader" columnResizeMode="fit" v-model:filters="filters"
                v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" v-model:selection="selected">
                <template #header>
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

                <Column :sortable="true" field="id" header="id" style="text-align: center">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id">
                        </InputText>
                    </template>
                </Column>
                <Column :sortable="true" field="firstName" header="First Name" filterField="firstName">
                    <template #body="{ data }">
                        {{ data.firstName }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by first name"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="lastName" header="Last Name">
                    <template #body="{ data }">
                        {{ data.lastName }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by last name"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="email" header="E-mail Address">
                    <template #body="{ data }">
                        {{ data.email }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by e-mail address"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="address" header="Address">
                    <template #body="{ data }">
                        {{ data.address }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by address"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="phoneHome" header="Home #">
                    <template #body="{ data }">
                        {{ data.phoneHome }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search home phone"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="phoneCell" header="Cell #">
                    <template #body="{ data }">
                        {{ data.phoneCell }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search cell phone"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" field="numMeals" header="Num. Meals">
                    <template #body="{ data }">
                        {{ data.numMeals }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search notes"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template>
                </Column>
                <Column :sortable="true" :style="{ maxWidth: '600px' }" field="notes" header="Notes">
                    <template #body="{ data }">
                        <!-- {{ data.notes }} -->
                        <a @click="() => openCommentsDialog(data)">...</a>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search notes"></InputText>
                    </template>
                    <!-- <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template> -->
                </Column>
                <template #groupheader="slotProps">
                    <span class="font-medium">{{ slotProps.data.routeName }}</span>
                </template>
                <template #groupfooter="slotProps">
                </template>
            </DataTable>
        </template>
    </ReportLayout>
</template>