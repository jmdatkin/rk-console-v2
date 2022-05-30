<script setup>
// import DataTableLayout from '@/Layouts/DataTableLayout';
import DateSelectLayout from '@/Layouts/DateSelectLayout';
// import  from '@/Layouts/Authenticated';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import { ref } from 'vue';
import axios from 'axios';
import DateSelect from '@/Components/DateSelect';
import RouteDriverTable from './RouteDriverTable';

const props = defineProps(['date', 'openDateSelect']);


</script>

<template>
    <DateSelectLayout>
        <!-- <DateSelect> -->
        <template v-slot="{ date, openDateSelect }">
            <Button @click="openDateSelect">Change Date</Button>
            <RouteDriverTable :date="date" :openDateSelect="openDateSelect"></RouteDriverTable>
        </template>

        <!-- </DateSelect> -->

    </DateSelectLayout>
</template>