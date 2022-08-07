<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';
import NavSidebar from '../Components/NavSidebar.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';

const sidebarOpen = ref(true);
const toggle = () => sidebarOpen.value = !sidebarOpen.value;
</script>

<template>
    <Authenticated>
        <div class="app-container flex flex-col md:flex-row">
            <nav :class="sidebarOpen ? 'sidebar-open' : 'sidebar-closed'"
                class="hidden md:block overflow-x-hidden overflow-y-scroll top-0 h-screen basis-48 shrink-0 grow-0 bg-white border-r">
                <a @click="toggle" label="Close" style="margin-left: 12rem"
                    class="absolute h-4 block bg-gray-200 hover:bg-gray-400">Close</a>
                <div class="flex justify-center space-x-2 items-center border-b border-gray-200 px-2 py-3">
                    <ApplicationLogo class="h-8"></ApplicationLogo>
                    <span class="tracking-tight align-middle font-bold">
                        <h4>
                            CCRK Console
                        </h4>
                    </span>
                </div>
                <NavSidebar></NavSidebar>
            </nav>
            <AdminMenuBar class="md:hidden"></AdminMenuBar>
            <main class="flex-grow flex-shrink overflow-x-hidden">
                <slot></slot>
            </main>

        </div>
    </Authenticated>
</template>

<style lang="scss">
.sidebar {
    transition: left 1s;
}

.sidebar-open {
    left: 0;
    position: sticky;
}

.sidebar-closed {
    left: -12rem;
    position: absolute;
}
</style>