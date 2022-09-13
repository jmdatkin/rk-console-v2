<script setup>
import SelectButton from 'primevue/selectbutton';
import { ref } from 'vue';

const items = ref([
    {name: 'Su', code: 0},
    {name: 'M', code: 1},
    {name: 'Tu', code: 2},
    {name: 'W', code: 3},
    {name: 'Th', code: 4},
    {name: 'F', code: 5},
    {name: 'Sa', code: 6},
]);
</script>

<template>
    <SelectButton :options="items" optionLabel="name" optionValue="code">

    </SelectButton>
</template>
