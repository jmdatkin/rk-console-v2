<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import DriverInfo from './DriverInfo';
import Divider from 'primevue/divider';
import DriverAssignments from './DriverAssignments';

import Card from 'primevue/card';
const props = defineProps(['data']);
</script>

<template>
    <SingleResourceLayout>
            <Card class="mt-4">
                <template #content>
                    <DriverInfo :data="data"></DriverInfo>
                    <Divider />
                    <DriverAssignments :driverData="data"></DriverAssignments> 
                </template>
            </Card>
    </SingleResourceLayout>
</template>
