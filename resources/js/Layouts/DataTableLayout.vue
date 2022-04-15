<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <AuthenticatedLayout>
        <slot></slot>
        <div class="relative flex pt-0 justify-center min-h-screen bg-gray-100 sm:pt-2">
            <div class="flex flex-col px-0 w-full max-w-screen-2xl">
                <div class="surface-section px-4 py-5 md:px-6 lg:px-8">
                    <ul class="list-none p-0 m-0 flex align-items-center font-medium mb-3">
                        <li>
                            <a class="text-500 no-underline line-height-3 cursor-pointer">Tables</a>
                        </li>
                        <li class="px-2">
                            <i class="pi pi-angle-right text-500 line-height-3"></i>
                        </li>
                        <li>
                            <span class="text-900 line-height-3">
                                <slot name="header"></slot>
                            </span>
                        </li>
                    </ul>
                    <div class="flex align-items-start flex-column lg:justify-content-between lg:flex-row">
                        <div>
                            <div class="font-medium text-3xl text-900">
                                <slot name="header"></slot>
                            </div>
                            <!-- <div class="flex align-items-center text-700 flex-wrap">
                                <div class="mr-5 flex align-items-center mt-3">
                                    <i class="pi pi-users mr-2"></i>
                                    <span>332 Active Users</span>
                                </div>
                                <div class="mr-5 flex align-items-center mt-3">
                                    <i class="pi pi-globe mr-2"></i>
                                    <span>9402 Sessions</span>
                                </div>
                                <div class="flex align-items-center mt-3">
                                    <i class="pi pi-clock mr-2"></i>
                                    <span>2.32m Avg. Duration</span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

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