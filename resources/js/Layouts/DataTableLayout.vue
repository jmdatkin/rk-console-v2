<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <AuthenticatedLayout>
        <div class="relative flex pt-0 justify-center min-h-screen bg-gray-100 sm:pt-2">
            <div class="flex flex-col px-4 w-full max-w-screen-2xl">
                <slot name="header"></slot>
                <!-- <Toolbar>
                <template #start>
                    <Button label="New" icon="pi pi-plus" class="mr-2" />
                    <Button label="Upload" icon="pi pi-upload" class="p-button-success" />
                    <i class="pi pi-bars p-toolbar-separator mr-2" />
                    <SplitButton label="Save" icon="pi pi-check" :model="items" class="p-button-warning"></SplitButton>
                </template>

                <template #end>
                    <Button icon="pi pi-search" class="mr-2" />
                    <Button icon="pi pi-calendar" class="p-button-success mr-2" />
                    <Button icon="pi pi-times" class="p-button-danger" />
                </template>
            </Toolbar> -->
                <div class="p-datatable-wrapper flex card">
                    <slot name="table"></slot>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="scss">
.p-datatable-wrapper {
    width: 100%;
}
</style>