<script setup>
import DateSelectLayout from '@/Layouts/DateSelectLayout';
import Button from 'primevue/button';

</script>

<template>
    <DateSelectLayout>
        <template #content="{ date, openDateSelect }">
            {{ date }}
            <Button @click="openDateSelect">Choose Date</Button>
        </template> 
    </DateSelectLayout>
</template>