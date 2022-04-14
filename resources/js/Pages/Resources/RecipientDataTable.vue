<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import FileUpload from 'primevue/fileupload';
import Dialog from 'primevue/dialog';
import { ref, onMounted, onUpdated } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { Inertia, onSuccess } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from 'primevue/usetoast';

const props = defineProps(['cols', 'data', 'errors', 'message']);

const filters = ref({
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
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

        'notes':
        {
            operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
        },

    }
};

onMounted(() => {
    initFilters();
});

const toast = useToast();
const loading = ref(true);
const editingRows = ref([]);
const selected = ref();
const newRecordDialog = ref(false);
const newRecordForm = useForm({
    firstName: null,
    lastName: null,
    email: null,
    phoneHome: null,
    phoneCell: null,
    notes: null,
});

const openNewRecordDialog = function () {
    console.log('opening');
    newRecordDialog.value = true;
    console.log(newRecordDialog.value);
}

const closeNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const onRowEditSave = function (event) {
    let { newData, index } = event;
    console.log(`${index}`);
    console.dir(newData);
    Inertia.patch(`/recipients/${newData.id}/update`, newData,
        {
            onSuccess: page => {
                toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
            },

            onError: errors => {
                toast.add({ severity: props.message.class, summary: 'Error', detail: props.message.detail, life: 3000 });
            }
        });
};

onUpdated(() => {
    // toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
});
</script>

<template>
    <DataTableLayout>
        <Dialog v-model:visible="newRecordDialog" :closeOnEscape="true" :closable="true" :draggable="false"
            :modal="true" @open="() => console.log('ME OPEN')" :breakpoints="{
                '960px': '75vw',
                '640px': '100vw'
            }" :style="{ width: '50vw' }">
            Add Record
            <form @submit.prevent="newRecordForm.post('/recipients/create')">
                <div>
                    <div class="grid p-fluid">
                        <div class="col-12 md:col-6">
                            <label for="newRecord.firstName">First Name</label>
                            <InputText id="newRecord.firstName" type="text" v-model="newRecordForm.firstName" />
                        </div>
                        <div class="col-12 md:col-6">
                            <label for="newRecord.lastName">Last Name</label>
                            <InputText type="text" v-model="newRecordForm.lastName" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <InputText type="text" v-model="newRecordForm.email" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12 md:col-6">
                            <InputText type="text" v-model="newRecordForm.phoneHome" />
                        </div>
                        <div class="col-12 md:col-6">
                            <InputText type="text" v-model="newRecordForm.phoneCell" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">

                            <InputText type="text" v-model="newRecordForm.notes" />
                        </div>
                    </div>
                    <Button type="submit" :disabled="newRecordForm.processing">Submit</Button>

                </div>
            </form>

        </Dialog>
        <template #header>
            Recipients
        </template>
        <template #table>
            <!-- <span v-for="(key,val) in props.cols">{{key}}  +  {{val}}</span> -->
            <DataTable :value="data" :paginator="true" :rows="10" class="p-datatable-recipients"
                :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'phoneHome', 'phoneCell', 'notes']"
                filterDisplay="menu" responsiveLayout="scroll" v-model:filters="filters" editMode="row" showGridlines
                :resizableColumns="true" columnResizeMode="fit" @row-edit-save="onRowEditSave"
                v-model:editingRows="editingRows">
                <template #header>
                    <Toolbar class="p-0">
                        <template #start>
                            <Button type="button" icon="pi pi-filter-slash" label="Clear Filters"
                                class="p-button-outlined" @click="initFilters()" />
                            <Button type="button" icon="pi pi-plus" label="Add Record" class="p-button-success"
                                @click="openNewRecordDialog" />
                            <FileUpload :auto="true" name="csv_data" mode="basic" accept=".csv" :maxFileSize="1000000"
                                label="Import from CSV" chooseLabel="Import from CSV" url="/recipients/import"
                                class="inline-block" />

                        </template>
                        <template #end>
                            <span class="p-input-icon-left ">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global'].value" placeholder="Search all columns" />
                            </span>

                        </template>

                    </Toolbar>
                    <!-- <div class="flex p-header" style="justify-content: space-between">
                        <div class="p-header-left">
                            <Button type="button" icon="pi pi-filter-slash" label="Clear Filters"
                                class="p-button-outlined" @click="initFilters()" />
                            <Button type="button" icon="pi pi-plus" label="Add Record" class="p-button-success"
                                @click="initFilters()" />

                        </div>
                        <div class="p-header-right">
                            <span class="p-input-icon-left ">
                                <i class="pi pi-search" />
                                <InputText v-model="filters['global'].value" placeholder="Search all columns" />
                            </span>

                        </div>
                    </div> -->
                </template>
                <template #loading>
                    Loading recipients, please wait...
                </template>
                <template #empty>
                    No recipients found.
                </template>
                <!-- <Column v-for="(header, data) in props.cols" :field="data" :header="header" :key="data"
                    style="min-width: 14rem;"
                    :sortable="true"></Column> -->

                <Column :sortable="true" field="id" header="id" style="text-align: center">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id"></InputText>
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
                <Column :sortable="true" field="notes" header="Notes">
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
                <Column :rowEditor="true" style="width:10%; min-width:8rem" bodyStyle="text-align:center"></Column>




                <!-- <Column field="code" header="Code"></Column>
            <Column field="name" header="Name"></Column>
            <Column field="category" header="Category"></Column>
            <Column field="quantity" header="Quantity"></Column> -->

            </DataTable>

        </template>

    </DataTableLayout>
</template>

<style lang="scss" scoped>
.p-toolbar {
    padding: 0;
}

.p-toolbar * {
    margin: 0 0.2rem;
}

.p-header div * {
    margin: 0 0.2rem;
}

.p-datatable {
    max-width: 1700px;
    margin: 0 auto;
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

::v-deep(.p-datatable.p-datatable-recipients) {
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
        padding: 0.5rem !important;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}
</style>

<style>
.p-button.p-fileupload-choose {
    overflow: initial !important;
    cursor: pointer;
}
</style>