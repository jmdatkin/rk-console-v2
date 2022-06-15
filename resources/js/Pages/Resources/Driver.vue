<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import DriverInfo from './Drivers/DriverInfo';
import Divider from 'primevue/divider';

const props = defineProps(['data']);
</script>

<template>
    <SingleResourceLayout>
        <Card class="mt-4">
            <template #content>
                <DriverInfo :data="data"></DriverInfo>
            </template>
        </Card>
    </SingleResourceLayout>
</template>
