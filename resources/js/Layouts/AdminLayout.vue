<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';
import NavSidebar from '../Components/NavSidebar.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <Authenticated>
        <div class="app-container flex">
            <nav class="top-0 h-screen sticky basis-48 shrink-0 grow-0 bg-white border-r block">
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
            <main class="flex-grow flex-shrink basis-0 overflow-x-hidden">
                <slot></slot>
            </main>

        </div>
    </Authenticated>
</template>

