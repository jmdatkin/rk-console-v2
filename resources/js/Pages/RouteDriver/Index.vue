<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import DateSelectLayout from '@/Layouts/DateSelectLayout';
// import  from '@/Layouts/Authenticated';
import Panel from 'primevue/panel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { ref } from 'vue';
import axios from 'axios';
import DateSelect from '@/Components/DateSelect';
import RouteDriverTable from './RouteDriverTable';
import Content from './Content';

const props = defineProps(['date', 'openDateSelect']);


</script>

<template>
    <DataTableLayout>
        <template #header>
            Substitute Drivers
        </template>
        <!-- <DateSelectLayout> -->
        <template #table>
            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <Content :openDateSelect="openDateSelect" :date="date"></Content>
                </template>
            </DateSelect>
        </template>

        <!-- </DateSelectLayout> -->
    </DataTableLayout>
</template>