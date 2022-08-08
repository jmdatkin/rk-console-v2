<script setup>
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';

const timezones = ref([
    {
        name: 'America/New York',
        code: 'Etc/US'
    }
]);


</script>

<template>

<Dropdown :options="timezones" optionLabel="name" optionValue="code" placeholder="Select a timezone"></Dropdown>
    
</template>