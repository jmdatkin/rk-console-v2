<script setup>
import DriverExceptions from './DriverExceptions';
import ReportLayout from '@/Layouts/ReportLayout';
import DriverSelect from '@/Components/DriverSelect';
import Button from 'primevue/button';

const props = defineProps(['driverData', 'exceptions']);

</script>

<template>
    <ReportLayout>
        <template #report>
            <DriverSelect>
                <template v-slot="{ driver, openDriverSelect }">
                <Button @click="() => openDriverSelect()">Select Driver</Button>
                    <DriverExceptions :driverData="driver"></DriverExceptions>
                </template>
            </DriverSelect>
        </template>
    </ReportLayout>
</template>