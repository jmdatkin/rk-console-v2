<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import DataTableLayout from '../../Layouts/DataTableLayout.vue';
import Audit from '../../Components/Audit.vue';
import Divider from 'primevue/divider';

defineProps(['data'])
</script>

<template>
    <DataTableLayout>
        <template #table>
            <!-- <DataTable v-for="audit in data" :value="audit" :showGridlines="true"
            :groupRowsBy="['id', 'user.firstName','user.lastName']" rowGroupMode="rowspan" >
                <Column header="User First Name" field="user.firstName"></Column>
                <Column header="User Last Name" field="user.lastName"></Column>
                <Column header="Attribute" field="attribute"></Column>
                <Column header="Old Value" field="old_value"></Column>
                <Column header="New Value" field="new_value"></Column>
            </DataTable> -->
            <div v-for="audit in data">
            <Audit :data="audit"></Audit>
            <Divider></Divider>
            </div>
        </template>
    </DataTableLayout>
</template>