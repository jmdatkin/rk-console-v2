<script setup>
defineProps(['show']);
</script>

<template>
    <span v-if="show">
        <i class="pi pi-spin pi-spinner text-gray-600" style="font-size: 2rem"></i>
    </span>
</template>