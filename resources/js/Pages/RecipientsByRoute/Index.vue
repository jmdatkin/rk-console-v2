<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import SidebarLayout from '../../Layouts/SidebarLayout';
import DateSelectLayout from '@/Layouts/DateSelectLayout';
// import  from '@/Layouts/Authenticated';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { ref } from 'vue';
import axios from 'axios';
import DateSelect from '@/Components/DateSelect';
import RecipientsByRouteTable from './RecipientsByRouteTable';


</script>
<template>
    <DataTableLayout>
        <Head title="Drivers By Route"></Head>
        <template #header>
            Recipients by Route
        </template>
        <!-- <DateSelectLayout> -->
        <template #table>
            <DateSelect :limitSelect="true" >
                <template v-slot="{ date, openDateSelect }">
                    <!-- <Button @click="openDateSelect">Change Date</Button> -->
                    <RecipientsByRouteTable :date="date" :openDateSelect="openDateSelect"></RecipientsByRouteTable>
                </template>

            </DateSelect>
        </template>

        <!-- </DateSelectLayout> -->
    </DataTableLayout>
</template>