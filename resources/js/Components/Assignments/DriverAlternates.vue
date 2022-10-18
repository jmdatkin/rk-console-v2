<script setup>
import { ref, onUpdated, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import axios from 'axios';
import { routeFilters } from '@/filters';
import { useToast } from 'primevue/usetoast';

const props = defineProps(['driver_data'])

// Toast notifications
const toast = useToast();

const filters = ref(routeFilters);
const initFilters = function () {
    filters.value = routeFilters;
};

const selected = ref(null);
const onRowSelect = function (event) {
    let { data } = event;
    axios.get(`/driver/${props.driver_data.id}/alternates/attach/${data.id}`)
        .then(res => {
            toast.add({ severity: 'success', summary: 'Successful', detail: 'Record successfully modified.', life: 3000 });
        }).catch(err => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'An error occurred. Record was not modified.', life: 3000 });
        });
};
const onRowUnselect = function (event) {
    let { data } = event;
    axios.get(`/driver/${props.driver_data.id}/alternates/detach/${data.id}`)
        .then(res => {
            toast.add({ severity: 'success', summary: 'Successful', detail: 'Record successfully modified.', life: 3000 });
        }).catch(err => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'An error occurred. Record was not modified.', life: 3000 });
        });
};

const routes = ref([]);
const getRouteData = function () {
    axios.get('/route/')
        .then(res => {
            routes.value = res.data;
        });
};

const data = ref([]);
const getData = function () {
    axios.get(`/driver/${props.driver_data.id}/alternates`)
        .then(res => {
            data.value = res.data;
            selected.value = data.value.map(r => {
                let { pivot, ...result } = r;
                return result;
                // return { pivot, ...r}
            });
        });
};

getRouteData();

onMounted(() => {
    getData();
});

</script>
<template>
    <DataTable :value="routes" :paginator="true" :rows="10" class="p-datatable-routes"
        :globalFilterFields="['id', 'name', 'notes']" filterDisplay="menu" responsiveLayout="scroll" showGridlines
        :resizableColumns="true" columnResizeMode="fit" v-model:filters="filters" v-model:selection="selected"
        @row-select="onRowSelect" @row-unselect="onRowUnselect">
        <template #header>
            {{ driver_data.firstName }} {{ driver_data.lastName }}
        </template>
        <Column selectionMode="multiple" headerStyle="width: 3em">
        </Column>

        <Column :sortable="true" field="id" header="id" style="text-align: center">
            <template #body="{ data }">
                {{ data.id }}
            </template>
            <template #filter="{ filterModel }">
                <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by id">
                </InputText>
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
    </DataTable>
</template>