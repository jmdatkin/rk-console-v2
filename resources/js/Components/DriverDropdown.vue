<script setup>
import Dropdown from 'primevue/dropdown';
import { ref } from 'vue';

const props = defineProps(['initialValue']);

const data = ref([]);
const selected = ref(props.initialValue);

axios.get(route('driver.all')).then(res => data.value = res.data);

const label = r => `${r.person.firstName} ${r.person.lastName}`; 
</script>

<template>
<Dropdown v-model="selected"
:options="data"
:optionLabel="label"
optionValue="id"
:filter="true"
filterPlaceholder="Search for driver"
:filterFields="['person.firstName, person.lastName']"
></Dropdown>
</template>