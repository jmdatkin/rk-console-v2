<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';
import AdminNavSidebar from '../Components/AdminNavSidebar.vue';
</script>

<template>
    <Authenticated>
        <div class="app-container flex flex-col md:flex-row">
            <AdminNavSidebar
                class="hidden md:block sticky overflow-x-hidden overflow-y-scroll top-0 h-screen basis-48 shrink-0 grow-0 bg-white border-r">
            </AdminNavSidebar>
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