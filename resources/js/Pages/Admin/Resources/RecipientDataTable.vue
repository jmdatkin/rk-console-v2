<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import Textarea from 'primevue/textarea';
import Dropdown from 'primevue/dropdown';
import Dialog from 'primevue/dialog';
import Loading from '@/Components/Loading';
import ContextMenu from 'primevue/contextmenu';
import Badge from 'primevue/badge';
import Chip from 'primevue/chip';
import RecipientRouteAssignments from '@/Components/Assignments/RecipientRouteAssignments';
import InputSwitch from 'primevue/inputswitch';
import { Head } from '@inertiajs/inertia-vue3';
import { ref, onMounted, reactive, computed } from 'vue';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { mergePersonObject } from '@/util';
import { recipientFilters } from '@/filters';
import { useCRUD, usePending } from '@/hooks';
import RecipientService from '@/Service/RecipientService';
import { Inertia } from '@inertiajs/inertia';
import FullscreenDataTable from '../../../Components/FullscreenDataTable.vue';
import DatatableButtonSet from '../../../Components/DatatableButtonSet.vue';

const props = defineProps(['agencies', 'pending_jobs', 'csrf']);

const { data, dataLoaded, selected, CRUD } = useCRUD(RecipientService);

const tableData = computed(() => {
    return data.value.map(mergePersonObject);
});

const rowClass = (row) => {
    if (row.pending) return 'pending';
    return '';
};

// const pendingUpdates = computed(() => {
//     return props.pending_jobs.filter(job => job.job_name.indexOf('update') > 0);
// });

// const tableDataWithPending = computed(() => {
//     const newData = _.cloneDeep(tableData.value);
//     pendingUpdates.value.forEach(update => {
//         let idx = newData.findIndex(row => row.id == update.payload[0]);
//         console.log(idx);
//         if (idx < 0) return;
//         let payload = update.payload[1];
//         let row = newData[idx];
//         Object.assign(row, payload);
//         // row = {...payload, ...row};
//         newData[idx] = {pending: true, ...row};
//     });
//     return newData;
// });
const tableDataWithPending = usePending(props.pending_jobs, tableData);

const conditionalTableData = computed(() => {
    return showPending.value ? tableDataWithPending.value : tableData.value;
});

// DataTable filters
const filters = ref(recipientFilters);
const initFilters = function () {
    filters.value = recipientFilters;
};

const showPending = ref(false);

// Confirm dialog
const confirm = useConfirm();

// Context menu
const cmSelection = ref();
const cm = ref();
const menuModel = ref([
    { label: 'View record', icon: 'pi pi-fw pi-search', command: () => viewRecord(cmSelection.value) },
    { label: 'Edit record', icon: 'pi pi-fw pi-pencil', command: () => editingRows.value = [...editingRows.value, cmSelection.value] },
    { label: 'Delete record', icon: 'pi pi-fw pi-trash', command: () => destroyRecords([cmSelection.value.id]) },
    { label: 'Edit route assignments', icon: 'pi pi-fw pi-pencil', command: () => openAssignDialog(cmSelection.value) }
]);
const onRowContextMenu = event => {
    cm.value.show(event.originalEvent);
};

const viewRecord = function (record) {
    Inertia.visit(`/recipient/${record.id}`);
};

// Toast notifications
const toast = useToast();

// New record
const newRecordDialog = ref(false);
const newRecordForm = reactive({
    agency_id: null,
    firstName: null,
    lastName: null,
    email: null,
    address: null,
    phoneHome: null,
    phoneCell: null,
    numMeals: null,
    notes: null,
});

const openNewRecordDialog = function () {
    newRecordDialog.value = true;
};

const closeNewRecordDialog = function () {
    newRecordDialog.value = false;
};

const submitNewRecord = function () {
    CRUD.store(newRecordForm);
};

// Edit record
const editingRows = ref([]);
const onRowEditSave = function (event) {
    CRUD.update(event.newData);
};

// Destroy record
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


// Recipient assignments
const assignRecipient = ref(null);
const assignId = ref(null);
const assignDialog = ref(false);

const openAssignDialog = function (row) {
    assignRecipient.value = row;
    assignId.value = row.id;
    assignDialog.value = true;
};


// CSV Upload
// const beforeUpload = function (event) {
//     event.xhr.setRequestHeader('Content-type', 'text/csv');
//     event.xhr.setRequestHeader('X-CSRF-TOKEN', props.csrf);
// };

// const onUpload = function (event) {
//     let { files } = event;
//     let fr = new FileReader();

//     fr.readAsText(files[0]);

//     fr.onload = () => {
//         Inertia.post('/recipient/import', {
//             data: fr.result,
//         }, {
//             onBefore: () => {
//                 dataLoaded.value = false;
//             },
//             onFinish: () => {
//                 fetchData();
//             },
//             onSuccess: page => {
//                 toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
//             },

//             onError: errors => {
//                 toast.add({ severity: props.message.class, summary: 'Error', detail: props.message.detail, life: 3000 });
//             }
//         })

//     };
// };

// Lifecycle hooks
onMounted(() => {
    initFilters();
});

// Setup
CRUD.get();
</script>

<template>
    <DataTableLayout>

        <Head title="Recipients" />
        <Dialog v-model:visible="newRecordDialog" :closeOnEscape="true" :closable="true" :draggable="false"
            :modal="true" :breakpoints="{
                '960px': '75vw',
                '640px': '100vw'
            }" :style="{ width: '50vw' }" :dismissableMask="true">

            <template #header>
                <h5 class="font-semibold">Add Record</h5>
                <!-- <strong>Add Record</strong> -->
            </template>

            <form @submit.prevent="submitNewRecord">
                <div>
                    <div class="grid p-field">
                        <div class="col-12 sm:col-6">
                            <label for="newRecord.firstName">First Name</label>
                            <InputText class="p-form-input" id="newRecord.firstName" type="text"
                                v-model="newRecordForm.firstName" />
                        </div>
                        <div class="col-12 sm:col-6">
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
                    <div class="grid p-field">
                        <div class="col-12">
                            <label for="newRecord.phoneHome">Home Phone</label>
                            <InputText class="p-form-input" id="newRecord.phoneHome" type="text"
                                v-model="newRecordForm.phoneHome" />
                        </div>
                        <div class="col-12">
                            <label for="newRecord.phoneCell">Cell Phone</label>
                            <!-- <InputText class="p-form-input" id="newRecord.phoneCell" type="text"
                                v-model="newRecordForm.phoneCell" /> -->
                            <InputMask class="p-form-input" :id="'newRecord.phoneCell'"
                                v-model="newRecordForm.phoneCell" mask="(999) 999-9999? x99999"></InputMask>
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.email">Address</label>
                            <InputText class="p-form-input" id="newRecord.address" type="text"
                                v-model="newRecordForm.address" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.email">Num. Meals</label>
                            <InputText class="p-form-input" id="newRecord.numMeals" type="text"
                                v-model="newRecordForm.numMeals" />
                        </div>
                    </div>
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.agency_id">Agency</label>
                            <Dropdown id="newRecord.agency_id" v-model="newRecordForm.agency_id"
                                :options="props.agencies" optionValue="id" :filter="true" optionLabel="name"
                                placeholder="Select agency" />
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

        <Dialog v-model:visible="assignDialog" :closeOnEscape="true" :closable="true" :dismissableMask="true"
            :modal="true" :breakpoints="{
                '960px': '75vw',
                '640px': '100vw'
            }" :style="{ width: '50vw' }">
            <template #header>
                <h5 class="font-medium"></h5>
            </template>
            <!-- <ManageRecipient :recipient_id="assignId" :recipientData="assignRecipient">

            </ManageRecipient> -->
            <RecipientRouteAssignments :recipientData="assignRecipient"></RecipientRouteAssignments>
        </Dialog>


        <!-- BEGIN DT -->
        <template #header>
            Recipients
        </template>
        <template #table>
            <!-- <FullscreenDataTable> -->
                <DataTable :value="conditionalTableData" :paginator="true" :rows="15" class="p-datatable-recipients"
                    :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'address', 'phoneHome', 'phoneCell', 'numMeals', 'notes']"
                    dataKey="id" @row-click="e => viewRecord(e.data)" filterDisplay="menu" responsiveLayout="scroll"
                    editMode="row" showGridlines :resizableColumns="true" columnResizeMode="fit"
                    v-model:filters="filters" v-model:editingRows="editingRows" contextMenu
                    v-model:contextMenuSelection="cmSelection" :rowClass="rowClass" stateStorage="local"
                    stateKey="dt-recipient-session" @rowContextmenu="onRowContextMenu" @row-edit-save="onRowEditSave"
                    v-model:selection="selected">
                    <template #header>
                        <Toolbar class="p-0">
                            <template #start>
                                <!-- <Button type="button" icon="pi pi-filter-slash" label="Clear Filters"
                                    class="p-button-outlined p-button-sm" @click="initFilters()" />
                                <span class="p-buttonset">
                                    <Button icon="pi pi-plus" label="Add Record" class="p-button-success p-button-sm"
                                        @click="openNewRecordDialog" />
                                    <Button :disabled="!selected || !selected.length" icon="pi pi-trash"
                                        label="Delete Records" class="p-button-alert p-button-sm"
                                        @click="destroySelected" />
                                </span> -->
                                <DatatableButtonSet @clearFilterClick="initFilters()" @addClick="openNewRecordDialog" @destroyClick="destroySelected" :selected="selected"></DatatableButtonSet>
                                <Badge :value="pending_jobs.length"></Badge>
                                <InputSwitch value="Show pending data" :binary="true" v-model="showPending" />
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
                    <Column :sortable="true" field="agency.name" header="Agency" filterField="agency.name">
                        <template #body="{ data }">
                            {{ data.agency.name }}
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                                class="p-column-filter" placeholder="Search by first name"></InputText>
                        </template>
                        <!-- <template #editor="{ data, field }">
                        <InputText v-model="data[field]" autofocus />
                    </template> -->
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
                    <Column :sortable="true" field="paused" header="Status">
                        <template #body="{ data }">
                            <Chip :class="{
                                'p-status-active' : !data.paused,
                                'p-status-paused' : data.paused
                            }">
                            {{ data.paused ? 'Paused' : 'Active' }}
                            </Chip>
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                                class="p-column-filter" placeholder="Search notes"></InputText>
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
                    <Column frozen alignFrozen="right" style="width:10%; min-width:4rem" bodyStyle="text-align:center">
                        <template #body="{ data }">
                            <a @click="() => openAssignDialog(data)">
                                <i class="pi pi-folder-open"></i>
                            </a>
                            <!-- <Button @click="() => openAssignDialog(data)" class="p-button-rounded"
                            icon="pi pi-folder-open"></Button> -->
                        </template>
                    </Column>
                    <Column frozen alignFrozen="right" :rowEditor="true" style="width:10%; min-width:4rem"
                        bodyStyle="text-align:center">
                    </Column>

                    <ContextMenu :model="menuModel" ref="cm"></ContextMenu>
                </DataTable>
            <!-- </FullscreenDataTable> -->
        </template>
    </DataTableLayout>
</template>

<style lang="scss">

.pending {
    background-color: var(--blue-100) !important;
}

.p-chip.p-status-active {
    background-color: var(--green-300);
    color: var(--green-800);
}
</style>
