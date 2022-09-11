<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import Chip from 'primevue/chip';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import Dialog from 'primevue/dialog';
import ContextMenu from 'primevue/contextmenu';
import Loading from '@/Components/Loading';
import { Head } from '@inertiajs/inertia-vue3';
import { ref, onMounted, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { personFilters } from '@/filters';
import { useCRUD } from '@/hooks';
import PersonService from '@/Service/PersonService';
import DatatableButtonSet from '../../../Components/DatatableButtonSet.vue';
import DataTableOptionsLink from '../../../Components/DataTableOptionsLink.vue';

const props = defineProps(['message', 'csrf']);

const { data, dataLoaded, selected, CRUD } = useCRUD(PersonService);

// DataTable filters
const filters = ref(personFilters);
const initFilters = function () {
    filters.value = personFilters;
};

// Confirm dialog
const confirm = useConfirm();

// Context menu
const cmSelection = ref();
const cm = ref();
const menuModel = ref([
    { label: 'Edit record', icon: 'pi pi-fw pi-pencil', command: () => editingRows.value = [...editingRows.value, cmSelection.value] },
    { label: 'Delete record', icon: 'pi pi-fw pi-trash', command: () => destroyRecords([cmSelection.value.id]) },
]);
const onRowContextMenu = event => {
    cm.value.show(event.originalEvent);
};

const viewRecord = function (record) {
    Inertia.visit(`/personnel/${record.id}`);
};

// Toast notifications
const toast = useToast();

// New record form
const newRecordDialog = ref(false);
const newRecordForm = reactive({
    firstName: null,
    lastName: null,
    email: null,
    phoneHome: null,
    phoneCell: null,
    notes: null,
});

const openNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const closeNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const submitNewRecord = function () {
    CRUD.store(newRecordForm);
};


// Row editing
const editingRows = ref([]);
const onRowEditSave = function (event) {
    // Extract only changed attributes
    let data = Object.keys(event.newData)
    .filter(key => event.newData[key] !== event.data[key])
    .reduce((obj, key) => {
        return Object.assign(obj, {[key]: event.newData[key]});
    }, {});
    CRUD.update(event.data.id, data);
};

// Record destroy
const destroyRecords = function (ids) {
    confirm.require({
        message: `Are you sure you want to delete record(s): [${ids.join(', ')}]?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
        accept: () => {
            CRUD.destroy(ids);
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'Cancelled', detail: 'Delete operation cancelled by user.', life: 3000 });
        }
    });
};

const destroySelected = function () {
    destroyRecords(selected.value.map(row => row.id));
};

// CSV Upload
const onUpload = function (event) {
    CRUD.upload(event.files);
};

CRUD.get();

onMounted(() => {
    initFilters();
});
</script>

<template>
    <DataTableLayout>

        <Head title="Personnel" />
        <Dialog v-model:visible="newRecordDialog" :closeOnEscape="true" :closable="true" :draggable="false"
            :modal="true" :breakpoints="{
                '960px': '75vw',
                '640px': '100vw'
            }" :style="{ width: '50vw' }" :dismissableMask="true">

            <template #header>
                <h5 class="font-semibold">Add Record</h5>
            </template>

            <form @submit.prevent="submitNewRecord">
                <div>
                    <div class="grid p-field">
                        <div class="col-12">
                            <label for="newRecord.firstName">First Name</label>
                            <InputText class="p-form-input" id="newRecord.firstName" type="text"
                                v-model="newRecordForm.firstName" />
                        </div>
                        <div class="col-12">
                            <label for="newRecord.lastName">Last Name</label>
                            <InputText class="p-form-input" id="newRecord.lastName" type="text"
                                v-model="newRecordForm.lastName" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.email">E-mail Address</label>
                            <InputText class="p-form-input" id="newRecord.email" type="text"
                                v-model="newRecordForm.email" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.phoneHome">Home Phone</label>
                            <InputText class="p-form-input" id="newRecord.phoneHome" type="text"
                                v-model="newRecordForm.phoneHome" />
                        </div>
                        <div class="col-12">
                            <label for="newRecord.phoneCell">Cell Phone</label>
                            <InputText class="p-form-input" id="newRecord.phoneCell" type="text"
                                v-model="newRecordForm.phoneCell" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.notes">Notes</label>
                            <Textarea class="p-form-input" id="newRecord.notes" type="text"
                                v-model="newRecordForm.notes" />
                        </div>
                    </div>
                    <Button type="submit" :disabled="newRecordForm.processing">Submit</Button>

                </div>
            </form>

        </Dialog>
        <template #header>
            Personnel
        </template>
        <template #options>
            <DataTableOptionsLink></DataTableOptionsLink>
        </template>
        <template #table>
            <DataTable :value="data" :paginator="true" :rows="15" class="p-datatable-persons"
                :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'phoneHome', 'phoneCell', 'notes']"
                filterDisplay="menu" responsiveLayout="scroll" editMode="row" showGridlines :resizableColumns="true"
                @row-click="e => viewRecord(e.data)" columnResizeMode="fit" v-model:filters="filters"
                v-model:editingRows="editingRows" contextMenu v-model:contextMenuSelection="cmSelection"
                dataKey="id"
                @rowContextmenu="onRowContextMenu" @row-edit-save="onRowEditSave" v-model:selection="selected">
                <template #header>
                    <Toolbar class="p-0">
                        <template #start>
                            <FileUpload :auto="true" name="csv_data" mode="basic" accept=".csv" :maxFileSize="1000000"
                                class="hidden" :customUpload="true" @uploader="onUpload" />
                            <DatatableButtonSet @clearFilterClick="initFilters()" @addClick="openNewRecordDialog"
                                @destroyClick="destroySelected" :selected="selected"></DatatableButtonSet>
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

                <Column selectionMode="multiple" headerStyle="width: 3em">
                </Column>

                <Column :sortable="true" field="id" header="id" style="max-width: 10%; text-align: center">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id"></InputText>
                    </template>
                </Column>
                <Column :sortable="true" field="roles" header="Roles" filterField="roles">
                    <template #body="{ data }">
                        <Chip v-for="role in data.roles" :class="{
                            'p-role-admin': role === 'admin',
                            'p-role-driver': role === 'driver',
                            'p-role-recipient': role === 'recipient'
                        }">
                            {{ role }}
                        </Chip>
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by role"></InputText>
                    </template>
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
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

                <ContextMenu :model="menuModel" ref="cm"></ContextMenu>
            </DataTable>

        </template>

    </DataTableLayout>
</template>

<style lang="scss">
.p-chip {
    // font-weight: 500;
}

.p-chip.p-role-admin {
    background-color: var(--purple-200);
    color: var(--purple-900);
}

.p-chip.p-role-driver {
    background-color: var(--blue-200);
    color: var(--blue-900);
}

.p-chip.p-role-recipient {
    background-color: var(--green-200);
    color: var(--green-900);
}
</style>