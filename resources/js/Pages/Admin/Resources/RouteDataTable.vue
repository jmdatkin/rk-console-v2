<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Dialog from 'primevue/dialog';
import FileUpload from 'primevue/fileupload';
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { routeFilters } from '@/filters';
import { useCRUD } from '@/hooks';
import RouteService from '../../../Service/RouteService';
import DatatableButtonSet from '../../../Components/DatatableButtonSet.vue';
import DataTableOptionsLink from '../../../Components/DataTableOptionsLink.vue';

const props = defineProps(['csrf']);

const { data, dataLoaded, selected, CRUD } = useCRUD(RouteService);

const filters = ref(routeFilters);
const initFilters = function () {
    filters.value = routeFilters;
};

// Confirm dialog
const confirm = useConfirm();

onMounted(() => {
    initFilters();
});

const toast = useToast();
const loading = ref(true);
const editingRows = ref([]);
const newRecordDialog = ref(false);
const newRecordForm = useForm({
    name: null,
    notes: null,
});

const openNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const closeNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const viewRecord = function (record) {
    Inertia.visit(`/route/${record.id}`);
};

const submitNewRecord = function () {
    CRUD.store(newRecordForm);
};

const onRowEditSave = function (event) {
    // Extract only changed attributes
    let data = Object.keys(event.newData)
    .filter(key => event.newData[key] !== event.data[key])
    .reduce((obj, key) => {
        return Object.assign(obj, {[key]: event.newData[key]});
    }, {});
    if (Object.keys(data).length <= 0) return;
    CRUD.update(event.data.id, data);
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

const destroySelected = function () {
    destroyRecords(selected.value.map(row => row.id));
};

// CSV Upload
const onUpload = function (event) {
    CRUD.upload(event.files);
};

CRUD.get();
</script>

<template>
    <DataTableLayout>
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
                    <div class="grid">
                        <div class="col-12">
                            <label for="newRecord.name">Name</label>
                            <InputText class="p-form-input" id="newRecord.name" type="text"
                                v-model="newRecordForm.name" />
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
            Routes
        </template>
        <template #options>
            <DataTableOptionsLink></DataTableOptionsLink>
        </template>
        <template #table>
            <DataTable :value="data" :paginator="true" :rows="15" class="p-datatable-routes" dataKey="id"
                :globalFilterFields="['id', 'name', 'notes']" filterDisplay="menu" responsiveLayout="scroll"
                editMode="row" showGridlines :resizableColumns="true" columnResizeMode="fit" v-model:filters="filters"
                @row-click="e => viewRecord(e.data)"
                v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" v-model:selection="selected">
                <template #header>
                    <Toolbar class="p-0">
                        <template #start>
                            <FileUpload :auto="true" name="csv_data" mode="basic" accept=".csv" :maxFileSize="1000000"
                                class="hidden" :customUpload="true" @uploader="onUpload" />
                            <DatatableButtonSet @clearFilterClick="initFilters()" @addClick="openNewRecordDialog"
                                @destroyClick="destroySelected" :selected="selected"></DatatableButtonSet>
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

                <Column :sortable="true" field="id" header="id" style="text-align: center">
                    <template #body="{ data }">
                        {{ data.id }}
                    </template>
                    <template #filter="{ filterModel }">
                        <InputText type="text" v-model="filterModel.value" class="p-column-filter"
                            placeholder="Search by id"></InputText>
                    </template>
                </Column>
                <Column :sortable="true" field="name" header="Name" filterField="name">
                    <template #body="{ data }">
                        {{ data.name }}
                    </template>
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()"
                            class="p-column-filter" placeholder="Search by first name"></InputText>
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
            </DataTable>

        </template>

    </DataTableLayout>
</template>

<style lang="scss" scoped>

</style>