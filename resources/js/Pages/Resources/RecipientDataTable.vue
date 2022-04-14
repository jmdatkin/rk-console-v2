<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { ref, onMounted, defineProps } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';

const props = defineProps(['cols', 'data']);

const filters = ref({
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        // value: null, matchMode: FilterMatchMode.CONTAINS
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
});


</script>

<template>
    <DataTableLayout>

        <template #table>
            <!-- <span v-for="(key,val) in props.cols">{{key}}  +  {{val}}</span> -->
            <DataTable :value="data" paginator="true" :rows="10"
                :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'phoneHome', 'phoneCell', 'notes']"
                filterDisplay="menu" responsiveLayout="scroll" v-model:filters="filters">
                <template #header>
                    <div class="flex" style="justify-content: space-between">

                        <Button type="button" icon="pi pi-filter-slash" label="Clear" class="p-button-outlined"
                            @click="clearFilter1()" />
                        <span class="p-input-icon-left ">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Search all columns" />
                        </span>
                    </div>
                </template>
                <!-- <Column v-for="(header, data) in props.cols" :field="data" :header="header" :key="data"
                    style="min-width: 14rem;"
                    :sortable="true"></Column> -->

                <Column sortable="true" field="id" header="id">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by name"></InputText>
                    </template>
                </Column>
                <Column sortable="true" field="firstName" header="First Name" filterField="firstName">
                    <template #body="{ data }">
                        {{ data.firstName }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by first name"></InputText>
                    </template>
                </Column>
                <Column sortable="true" field="lastName" header="Last Name">
                    <template #body="{ data }">
                        {{ data.lastName }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by last name"></InputText>
                    </template>
                </Column>
                <Column sortable="true" field="email" header="E-mail Address">
                    <template #body="{ data }">
                        {{ data.email }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by e-mail address"></InputText>
                    </template>
                </Column>
                <Column sortable="true" field="phoneHome" header="Home #">
                    <template #body="{ data }">
                        {{ data.phoneHome }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search home phone"></InputText>
                    </template>
                </Column>
                <Column sortable="true" field="phoneCell" header="Cell #">
                    <template #body="{ data }">
                        {{ data.phoneCell }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search cell phone"></InputText>
                    </template>
                </Column>
                <Column sortable="true" field="notes" header="Notes">
                    <template #body="{ data }">
                        {{ data.notes }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search notes"></InputText>
                    </template>
                </Column>




                <!-- <Column field="code" header="Code"></Column>
            <Column field="name" header="Name"></Column>
            <Column field="category" header="Category"></Column>
            <Column field="quantity" header="Quantity"></Column> -->

            </DataTable>

        </template>

    </DataTableLayout>
</template>

<style lang="scss" scoped>
.p-datatable {
    max-width: 1400px;
    width: 100%;
}

::v-deep(.p-paginator) {
    .p-paginator-current {
        margin-left: auto;
    }
}

::v-deep(.p-progressbar) {
    height: .5rem;
    background-color: #D8DADC;

    .p-progressbar-value {
        background-color: #607D8B;
    }
}

::v-deep(.p-datepicker) {
    min-width: 25rem;

    td {
        font-weight: 400;
    }
}

::v-deep(.p-datatable.p-datatable-customers) {
    .p-datatable-header {
        padding: 1rem;
        text-align: left;
        font-size: 1.5rem;
    }

    .p-paginator {
        padding: 1rem;
    }

    .p-datatable-thead>tr>th {
        text-align: left;
    }

    .p-datatable-tbody>tr>td {
        cursor: auto;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}
</style>