<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import { ref } from 'vue';

const sampleData = ref([
    {
        "id": 1,
        "code": 'ABC',
        "name": 'ABC2',
        "category": 'ABC4',
        "quantity": 10
    }
]
);

</script>

<template>
    <DataTableLayout>
        <Toolbar>
            <template #start>
                <Button label="New" icon="pi pi-plus" class="mr-2" />
                <Button label="Upload" icon="pi pi-upload" class="p-button-success" />
                <i class="pi pi-bars p-toolbar-separator mr-2" />
                <SplitButton label="Save" icon="pi pi-check" :model="items" class="p-button-warning"></SplitButton>
            </template>

            <template #end>
                <Button icon="pi pi-search" class="mr-2" />
                <Button icon="pi pi-calendar" class="p-button-success mr-2" />
                <Button icon="pi pi-times" class="p-button-danger" />
            </template>
        </Toolbar>
        <DataTable :value="sampleData">
            <Column field="code" header="Code"></Column>
            <Column field="name" header="Name"></Column>
            <Column field="category" header="Category"></Column>
            <Column field="quantity" header="Quantity"></Column>

        </DataTable>

    </DataTableLayout>
</template>