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
                    <div class="grid">
                        <div class="col-12 sm:col-8">
                            <Panel>
                                <RouteDriverTable :date="date" :openDateSelect="openDateSelect"></RouteDriverTable>
                            </Panel>

                        </div>
                        <div class="col-12 sm:col-4">
                            <Panel>
                            </Panel>
                        </div>
                    </div>
                </template>
            </DateSelect>
        </template>

        <!-- </DateSelectLayout> -->
    </DataTableLayout>
</template>