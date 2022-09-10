<script setup>
import DataTableLayout from '@/Layouts/DataTableLayout';
import DateSelect from '@/Components/DateSelect';
import RecipientsByRouteTable from '@/Components/RecipientsByRoute/RecipientsByRouteTable';


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