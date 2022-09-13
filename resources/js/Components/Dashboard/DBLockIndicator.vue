<script setup>
import Badge from 'primevue/badge';
defineProps(['status']);
</script>
<template>
    <div class="flex flex-col">
        <span>
            <span v-if="status">
                <Badge severity="success" value="&nbsp;"></Badge>
                DB is locked
            </span>
            <span v-else>
                <Badge value="&nbsp;"></Badge>
                DB is unlocked
            </span>
        </span>
    </div>
</template>