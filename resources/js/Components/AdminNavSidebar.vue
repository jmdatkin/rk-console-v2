<script setup>
import { Inertia } from '@inertiajs/inertia';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Menu from 'primevue/menu';
import { menuItems } from '../constants.js';
import { ref } from 'vue';

const items = ref(menuItems);
</script>

<template>
    <nav>
        <!-- <a @click="toggle" label="Close" style="margin-left: 12rem"
            class="absolute h-4 block bg-gray-200 hover:bg-gray-400">Close</a> -->
        <div class="flex justify-center space-x-2 items-center border-b border-gray-200 px-2 py-3">
            <ApplicationLogo class="h-8"></ApplicationLogo>
            <span class="tracking-tight align-middle font-bold">
                <h4>
                    CCRK Console
                </h4>
            </span>
        </div>
        <Menu :model="items">
        </Menu>
    </nav>
</template>

<style lang="scss">
.p-menu {
    border-radius: 0;
    border: 0;
    // height: 100%;
}
</style>
