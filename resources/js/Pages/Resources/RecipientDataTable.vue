<script setup lang="ts">
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
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
    <BreezeAuthenticatedLayout>
        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">

            <DataTable :value="sampleData">
                <Column field="code" header="Code"></Column>
                <Column field="name" header="Name"></Column>
                <Column field="category" header="Category"></Column>
                <Column field="quantity" header="Quantity"></Column>

            </DataTable>

        </div>
    </BreezeAuthenticatedLayout>
</template>