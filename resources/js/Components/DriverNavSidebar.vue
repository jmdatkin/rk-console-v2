<script setup>
import { Inertia } from '@inertiajs/inertia';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Menu from 'primevue/menu';
import { driverMenuItems } from '../constants.js';
import { ref } from 'vue';

const items = ref(driverMenuItems);
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
        <div class="border-t border-gray-200 px-2 py-3">

        </div>
    </nav>
</template>

<style lang="scss">
.p-menu {
    border-radius: 0;
    border: 0;
    // height: 100%;
}

$scrollbar-color: rgb(225, 226, 228);
$scrollbar-color-hover: rgb(210, 212, 216);
$scrollbar-color-active: rgb(204, 205, 207);

// Use native mobile scrollbar
@media only screen and (min-width: 768px) {

    /* ===== Scrollbar CSS ===== */
    /* Firefox */
    nav {
        scrollbar-width: thin;
        scrollbar-color: $scrollbar-color transparent;
    }

    nav:hover {
        scrollbar-color: $scrollbar-color-hover transparent;
    }

    nav:active {
        scrollbar-color: $scrollbar-color-active transparent;
    }

    /* Chrome, Edge, and Safari */
    nav::-webkit-scrollbar {
        width: 12px;
    }

    nav::-webkit-scrollbar-track {
        background: transparent;
    }

    nav::-webkit-scrollbar-thumb {
        background-color: $scrollbar-color;
        border-radius: 10px;
        border: 3px solid #ffffff;
    }

    nav::-webkit-scrollbar-thumb:hover {
        background-color: $scrollbar-color-hover;
    }

    nav::-webkit-scrollbar-thumb:active {
        background-color: $scrollbar-color-active;
    }

}
</style>
