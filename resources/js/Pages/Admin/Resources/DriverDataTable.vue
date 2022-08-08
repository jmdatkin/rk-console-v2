<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import Dialog from 'primevue/dialog';
import Loading from '@/Components/Loading';
import ContextMenu from 'primevue/contextmenu';
import ManageDriver from '@/Components/Assignments/ManageDriver';
import DriverAlternates from '@/Components/Assignments/DriverAlternates';
import Badge from 'primevue/badge';
import Checkbox from 'primevue/checkbox';
import InputSwitch from 'primevue/inputswitch';
import { ref, onMounted, onUpdated, reactive, computed } from 'vue';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { mergePersonObject } from '@/util';
import { driverFilters } from '@/filters';
import DriverService from '@/Service/DriverService';
import { useCRUD, usePending } from '@/hooks';
import DatatableButtonSet from '../../../Components/DatatableButtonSet.vue';

const props = defineProps(['pending_jobs', 'errors', 'message', 'csrf']);

const { data, dataLoaded, selected, CRUD } = useCRUD(DriverService);

const tableData = computed(() => {
    return data.value.map(mergePersonObject);
});

const tableDataWithPending = usePending(props.pending_jobs, tableData);

const conditionalTableData = computed(() => {
    return showPending.value ? tableDataWithPending.value : tableData.value;
});

const goToReport = function (selection) {
    Inertia.visit('/reports/driver?did=' + selection.value.id);
};

// DataTable filters
const filters = ref(driverFilters);
const initFilters = function () {
    filters.value = driverFilters;
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
    { label: 'Edit route assignments', icon: 'pi pi-fw pi-pencil', command: () => openAssignDialog(cmSelection.value.id) },
    { label: 'Edit alternate routes', icon: 'pi pi-fw pi-pencil', command: () => openAlternatesDialog(cmSelection.value) },
    { label: 'Schedule unavailability', icon: 'pi pi-fw pi-pencil', command: () => visitDriverStatus(cmSelection.value.id) },
    { label: 'View report', icon: 'pi pi-fw pi-search', command: () => goToReport(cmSelection) }
]);
const onRowContextMenu = event => {
    cm.value.show(event.originalEvent);
};

const viewRecord = function (record) {
    Inertia.visit(`/driver/${record.id}`);
};

// Toast notifications
const toast = useToast();

const newRecordDialog = ref(false);
const newRecordForm = reactive({
    firstName: null,
    lastName: null,
    email: null,
    phoneHome: null,
    phoneCell: null,
    notes: null,
});

// Assignments
const assignId = ref(null);
const assignDialog = ref(false);

const openAssignDialog = function (id) {
    assignId.value = id;
    assignDialog.value = true;
};

// Alternate route assignments
const driverAlternate = ref(null);
const alternatesDialog = ref(false);

const openAlternatesDialog = function (driver) {
    driverAlternate.value = driver;
    alternatesDialog.value = true;
};

// Driver status
const visitDriverStatus = function (id) {
    Inertia.visit('/driverstatus?did=' + id);
};

// New record
const openNewRecordDialog = function () {
    newRecordDialog.value = true;
};
const closeNewRecordDialog = function () {
    newRecordDialog.value = true;
};

const submitNewRecord = function () {
    CRUD.store(newRecordForm);
};

//Edit record
const editingRows = ref([]);
const onRowEditSave = function (event) {
    CRUD.update(event.newData);
};

// Destroy record
const destroySelected = function () {
    destroyRecords(selected.value.map(row => row.id));
};

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

// CSV upload
// const beforeUpload = function (event) {
//     event.xhr.setRequestHeader('Content-type', 'text/csv');
//     event.xhr.setRequestHeader('X-CSRF-TOKEN', props.csrf);
// };

// const onUpload = function (event) {
//     let { files } = event;
//     let fr = new FileReader();


//     fr.readAsText(files[0]);

//     fr.onload = () => {
//         Inertia.post('/driver/import', {
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

// }

onMounted(() => {
    initFilters();
});

// fetchData();
CRUD.get();

</script>

<template>
    <DataTableLayout>

        <Head title="Drivers" />
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

        <Dialog v-model:visible="assignDialog" :closeOnEscape="true" :closable="true" :modal="true"
            :dismissableMask="true">
            <template #header>
                <h5 class="font-semibold"></h5>
            </template>
            <ManageDriver :driver_id="assignId">

            </ManageDriver>
        </Dialog>

        <Dialog v-model:visible="alternatesDialog" :closeOnEscape="true" :closable="true" :modal="true"
            :dismissableMask="true">
            <template #header>
                <h5 class="font-medium"></h5>
            </template>
            <DriverAlternates :driver_data="driverAlternate">

            </DriverAlternates>
        </Dialog>


        <!-- BEGIN DT -->
        <template #header>
            Drivers
        </template>
        <template #table>
            <DataTable :value="conditionalTableData" :paginator="true" :rows="15" class="p-datatable-drivers"
                :globalFilterFields="['id', 'firstName', 'lastName', 'email', 'phoneHome', 'phoneCell', 'notes']"
                dataKey="id"
                @row-click="e => viewRecord(e.data)"
                filterDisplay="menu" responsiveLayout="scroll" editMode="row" showGridlines :resizableColumns="true"
                columnResizeMode="fit" v-model:filters="filters" v-model:editingRows="editingRows" contextMenu
                v-model:contextMenuSelection="cmSelection" @rowContextmenu="onRowContextMenu"
                @row-edit-save="onRowEditSave" v-model:selection="selected">
                <template #header>
                    <Toolbar class="p-0">
                        <template #start>
                                <DatatableButtonSet @clearFilterClick="initFilters()" @addClick="openNewRecordDialog" @destroyClick="destroySelected" :selected="selected"></DatatableButtonSet>
                            <!-- <Button type="button" icon="pi pi-filter-slash" label="Clear Filters"
                                class="p-button-outlined" @click="initFilters()" />
                            <Button type="button" icon="pi pi-plus" label="Add Record" class="p-button-success"
                                @click="openNewRecordDialog" />
                            <Button :disabled="!selected || !selected.length" type="button" icon="pi pi-trash"
                                label="Delete Records" class="p-button-alert" @click="destroySelected" /> -->
                            <Badge :value="pending_jobs.length"></Badge>
                            <InputSwitch value="Show pending data" :binary="true" v-model="showPending" />
                            <!-- <FileUpload :auto="true" name="csv_data" mode="basic" accept=".csv" :maxFileSize="1000000"
                                label="Import from CSV" chooseLabel="Import from CSV" url="/drivers/import"
                                class="inline-block" :customUpload="true" @uploader="onUpload" /> -->
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
                <Column style="width:10%; min-width:4rem" bodyStyle="text-align:center">
                    <template #body="{ data }">
                        <a @click="() => openAssignDialog(data.id)">
                            <i class="pi pi-folder-open"></i>
                        </a>
                        <!-- <Button @click="() => openAssignDialog(data.id)" class="p-button-rounded"
                            icon="pi pi-folder-open"></Button> -->
                    </template>
                </Column>
                <Column :rowEditor="true" style="width:10%; min-width:8rem" bodyStyle="text-align:center"></Column>

                <ContextMenu :model="menuModel" ref="cm"></ContextMenu>

            </DataTable>

        </template>

    </DataTableLayout>
</template>

<style lang="scss">
 
</style>