<script setup>
import moment from 'moment';
import { onBeforeUnmount, onMounted, ref } from 'vue';

const todayDatetime = ref(moment.tz().utcOffset(-240));

let iid;

onMounted(() => {
    iid = setInterval(() => todayDatetime.value = moment.tz().utcOffset(-240), 1000);
})

onBeforeUnmount(() => {
    clearInterval(iid);
});
</script>

<template>
    <h3>{{ todayDatetime.format("dddd DD MMM YYYY hh:mm A") }}</h3>
</template>

<style lang="scss">
</style>