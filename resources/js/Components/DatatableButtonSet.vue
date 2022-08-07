<script setup>
defineProps(['selected']);
</script>

<template>
    <!-- <div class="space-x-2"> -->
    <div class="">
        <Button icon="pi pi-filter-slash" class="p-button-outlined p-button-rounded"
            @click="$emit('clearFilterClick')" />
        <!-- <span class="p-buttonset"> -->
            <Button icon="pi pi-plus" class="p-button-success p-button-rounded" @click="$emit('addClick')" />
            <Button :disabled="!selected || !selected.length" icon="pi pi-trash" class="p-button-alert p-button-rounded"
                @click="$emit('destroyClick')" />
        <!-- </span> -->
    </div>
</template>

<style lang="scss">
.p-button-rounded .p-button-label {
    display: none;
}
</style>