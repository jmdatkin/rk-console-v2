<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps(['key']);
const val = ref();

const getValue = function() {
    axios.get('/settings?key='+props.key)
    .then(res => val.value = res.data);
};

onMounted(() => {
    getValue();
});

</script>

<template>
    <slot></slot>
</template>