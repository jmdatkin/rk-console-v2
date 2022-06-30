<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import FileUpload from 'primevue/fileupload';
import Dialog from 'primevue/dialog';
import { ref, onMounted, onUpdated } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-vue3';
import { useToast } from 'primevue/usetoast';
import { routeFilters } from './filters';

const props = defineProps(['cols', 'data', 'errors', 'message', 'csrf']);

const filters = ref(routeFilters);


const initFilters = function () {
    filters.value = routeFilters;
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
    name: null,
    notes: null,
});

const openNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const closeNewRecordDialog = function () {
    newRecordDialog.value = true;
}

const submitNewRecord = function () {
    newRecordForm.post('/route/store', {
        onSuccess: page => {
            toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
        },
        onError: errors => {
            toast.add({ severity: props.message.class, summary: 'Error', detail: props.message.detail, life: 3000 });
        }
    })
}

const onRowEditSave = function (event) {
    let { newData, index } = event;
    Inertia.patch(`/route/${newData.id}/update`, newData,
        {
            onSuccess: page => {
                toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
            },

            onError: errors => {
                toast.add({ severity: props.message.class, summary: 'Error', detail: props.message.detail, life: 3000 });
            }
        });
};

const destroyRecords = function () {
    let ids = selected.value.map(row => row.id);
    Inertia.post('/route/destroy', { ids },
        {
            onFinish: () => {
                selected.value = null;
            },
            onSuccess: page => {
                toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
            },

            onError: errors => {
                toast.add({ severity: props.message.class, summary: 'Error', detail: props.message.detail, life: 3000 });
            }
        }
    )
};

const beforeUpload = function (event) {
    event.xhr.setRequestHeader('Content-type', 'text/csv');
    event.xhr.setRequestHeader('X-CSRF-TOKEN', props.csrf);
};

const onUpload = function (event) {
    let { files } = event;
    let fr = new FileReader();

    fr.readAsText(files[0]);

    fr.onload = () => {
        Inertia.post('/route/import', {
            data: fr.result,
        }, {
            onSuccess: page => {
                toast.add({ severity: props.message.class, summary: 'Successful', detail: props.message.detail, life: 3000 });
            },

            onError: errors => {
                toast.add({ severity: props.message.class, summary: 'Error', detail: props.message.detail, life: 3000 });
            }
        });
    };

}
</script>

<template>
    <DataTableLayout>
        <Dialog v-model:visible="newRecordDialog" :closeOnEscape="true" :closable="true" :draggable="false"
            :modal="true" :breakpoints="{
                '960px': '75vw',
                '640px': '100vw'
            }" :style="{ width: '50vw' }" :dismissableMask="true">

            <template #header>
                <h5 class="font-medium">Add Record</h5>
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
        <template #table>
            <DataTable :value="data" :paginator="true" :rows="10" class="p-datatable-routes"
                :globalFilterFields="['id', 'name', 'notes']" filterDisplay="menu" responsiveLayout="scroll"
                editMode="row" showGridlines :resizableColumns="true" columnResizeMode="fit" v-model:filters="filters"
                v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" v-model:selection="selected">
                <template #header>
                    <Toolbar class="p-0">
                        <template #start>
                            <Button type="button" icon="pi pi-filter-slash" label="Clear Filters"
                                class="p-button-outlined" @click="initFilters()" />
                            <Button type="button" icon="pi pi-plus" label="Add Record" class="p-button-success"
                                @click="openNewRecordDialog" />
                            <Button type="button" icon="pi pi-plus" label="Delete Records" class="p-button-alert"
                                @click="destroyRecords" />
                            <!-- <FileUpload :auto="true" name="csv_data" mode="basic" accept=".csv" :maxFileSize="1000000"
                                label="Import from CSV" chooseLabel="Import from CSV" url="/routes/import"
                                class="inline-block" :customUpload="true" @uploader="onUpload" /> -->

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