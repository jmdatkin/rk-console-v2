<script setup>
import DriverException from './DriverException';

const props = defineProps(['exceptions']);
</script>

<template>

<DriverException v-for="exception in exceptions" :data="exception">
</DriverException>


</template>