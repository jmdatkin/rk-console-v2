<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Toolbar from 'primevue/toolbar';
import InputText from 'primevue/inputtext';
import { ref, onMounted, computed } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { mergePersonObject } from '@/util';

const props = defineProps(['data', 'driverData']);

const dataXform = computed(() => {
    let x = props.data.map(route => {
        console.log(route);
        let routeName = route.routeName;
        let recipients = route.recipients.map(recipient => {
            let newRecipient = mergePersonObject(recipient);
            newRecipient['routeName'] = routeName;
            return newRecipient;
        });
        return recipients;
    });
    return Array.prototype.concat.apply([], x);
});

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

onMounted(() => {
    initFilters();
});
</script>
<template>
    <DataTable :value="dataXform" :paginator="true" :rows="10" class="p-datatable-recipients"
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
                <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by id">
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
                {{ data.notes }}
            </template>
            <template #filter="{ filterModel, filterCallback }">
                <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                    class="p-column-filter" placeholder="Search notes"></InputText>
            </template>
            <template #editor="{ data, field }">
                <InputText v-model="data[field]" autofocus />
            </template>
        </Column>
        <template #groupheader="slotProps">
            <span class="font-medium">{{ slotProps.data.routeName }}</span>
        </template>
        <template #groupfooter="slotProps">
        </template>
    </DataTable>
</template>