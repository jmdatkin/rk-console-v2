<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';
import NavSidebar from '../Components/NavSidebar.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
<Authenticated>
    <!-- <Header>
        <AdminMenuBar></AdminMenuBar>
    </Header> -->
        <div class="app-container flex h-full w-full">
        <!-- <nav class="sidebar h-full basis-48">
            .
        </nav> -->
        <aside class="h-full basis-48 shrink-0 grow-0 bg-white border-r">
            <div class="flex space-x-2 border-b border-gray-200 p-2">
            <ApplicationLogo class="h-12"></ApplicationLogo>
            CCRK Console
            </div>
            <NavSidebar></NavSidebar>
        </aside>
        <!-- <main class="flex-grow"> -->
            <main class="flex-grow flex-shrink basis-0">
            <slot></slot>
        </main>

        </div>
    <!-- <main class="md:p-4 max-w-7xl mx-auto">
        <slot></slot>
    </main> -->
</Authenticated>
</template>

