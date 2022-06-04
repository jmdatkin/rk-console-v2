<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import DateSelectLayout from '@/Layouts/DateSelectLayout';
// import  from '@/Layouts/Authenticated';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { ref } from 'vue';
import axios from 'axios';
import DateSelect from '@/Components/DateSelect';
import RouteRecipientsTable from './RouteRecipientsTable';

</script>
<template>
    <DataTableLayout>
        <template #header>
            Route Driver View
        </template>
        <!-- <DateSelectLayout> -->
        <template #table>
            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <!-- <Button @click="openDateSelect">Change Date</Button> -->
                    <RouteRecipientsTable :date="date" :openDateSelect="openDateSelect"></RouteRecipientsTable>
                </template>

            </DateSelect>
        </template>

        <!-- </DateSelectLayout> -->
    </DataTableLayout>
</template>