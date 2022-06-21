<script setup>
import DriverExceptions from './DriverExceptions';
import ReportLayout from '@/Layouts/ReportLayout';
import DateSelect from '@/Components/DateSelect';
import Button from 'primevue/button';

const props = defineProps(['driverData', 'driverId']);

</script>

<template>
    <ReportLayout>
        <template #report>
            <DateSelect>
                <template v-slot="{ date, openDateSelect }">
                    <Button @click="() => openDateSelect()">Select Date</Button>
                    <DriverReport :driver="driverData" :date="date">
                    </DriverReport>
                </template>
            </DateSelect>
        </template>
    </ReportLayout>
</template>