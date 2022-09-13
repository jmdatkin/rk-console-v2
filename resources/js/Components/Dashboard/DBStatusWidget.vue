<script setup>
defineProps(['isLocked']);
</script>

<template>
    <span v-if="isLocked">
        <i class="pi pi-lock text-green-400"></i>
        DB locked
    </span>
    <span v-else>
        <i class="pi pi-lock-open text-blue-400"></i>
        DB unlocked
    </span>
</template>