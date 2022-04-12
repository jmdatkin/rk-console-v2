<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
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
            <DataTable :value="sampleData">
                <Column field="code" header="Code"></Column>
                <Column field="name" header="Name"></Column>
                <Column field="category" header="Category"></Column>
                <Column field="quantity" header="Quantity"></Column>

            </DataTable>

    </DataTableLayout>
</template>