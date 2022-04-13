<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout.vue';
import Column from 'primevue/column';
import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import { ref, onMounted, defineProps } from 'vue';

const props = defineProps(['cols', 'data']);

onMounted(() => console.log(props.cols));

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

        <template #table>
            <!-- <span v-for="(key,val) in props.cols">{{key}}  +  {{val}}</span> -->
            <DataTable :value="data" paginator="true" :rows="10"
                :globalFilterFields="Object.keys(props.cols)">
                <template #header>
                    <div class="flex justify-content-between">
                        <Button type="button" icon="pi pi-filter-slash" label="Clear" class="p-button-outlined"
                            @click="clearFilter1()" />
                        <span class="p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters1['global'].value" placeholder="Keyword Search" />
                        </span>
                    </div>
                </template>
                <template #empty>
                    No customers found.
                </template>
                <template #loading>
                    Loading customers data. Please wait.
                </template>
                <Column v-for="(header, data) in props.cols" :field="data" :header="header" 
                :key="data"
                :filterField="data"
                ></Column>

                <!-- <Column field="code" header="Code"></Column>
            <Column field="name" header="Name"></Column>
            <Column field="category" header="Category"></Column>
            <Column field="quantity" header="Quantity"></Column> -->

            </DataTable>

        </template>

    </DataTableLayout>
</template>