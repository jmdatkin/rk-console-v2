<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref } from 'vue';
import DriverService from '@/Service/DriverService';

const props = defineProps(['onSelectCallback']);

const data = ref([]);
const getData = function () {
    DriverService.get()
        .then(res => data.value = res.data);
};

const isDriverSelected = ref(false);
const selectedDriver = ref(null);
const select = function (event) {
    let rowData = event.data;
    selectedDriver.value = rowData;
    isDriverSelected.value = true;
};

const openDriverSelect = function () {
    isDriverSelected.value = false;
};

getData();
</script>
<template>
    <div v-if="!isDriverSelected">
        <DataTable selectionMode="single" :value="data" @row-select="select" :paginator="true" :rows="10" >
            <Column field="id" header="id">
            </Column>
            <Column field="person.firstName" header="First Name">
            </Column>
            <Column field="person.lastName" header="Last Name">
            </Column>
            <Column field="person.email" header="E-mail Address">
            </Column>
            <Column field="person.notes" header="Notes">
            </Column>
        </DataTable>
    </div>
    <div v-else>
        <slot :driver="selectedDriver" :openDriverSelect="openDriverSelect"></slot>
    </div>

</template>