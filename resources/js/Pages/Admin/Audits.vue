<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import DataTableLayout from '../../Layouts/DataTableLayout.vue';
import Audit from '../../Components/Audit.vue';
import Divider from 'primevue/divider';
import { Head } from '@inertiajs/inertia-vue3'
        

defineProps(['data'])
</script>

<template>
    <DataTableLayout>
    <template #header>
        Audits
    </template>

    <Head title="Audits"></Head>
        <template #table>
            <div v-for="audit in data">
            <Audit :data="audit"></Audit>
            <Divider></Divider>
            </div>
        </template>
    </DataTableLayout>
</template>