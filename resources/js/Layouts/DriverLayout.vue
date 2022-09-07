<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import DriverMenuBar from '../Components/DriverMenuBar.vue';
import DriverNavSidebar from '../Components/DriverNavSidebar.vue';
</script>

<template>
    <Authenticated>
        <div class="app-container flex flex-col md:flex-row">
            <DriverNavSidebar
                class="hidden md:block sticky overflow-x-hidden overflow-y-scroll top-0 h-screen basis-48 shrink-0 grow-0 bg-white border-r">
            </DriverNavSidebar>
            <DriverMenuBar class="md:hidden"></DriverMenuBar>
            <main class="flex-grow flex-shrink overflow-x-hidden">
                <slot></slot>
            </main>
        </div>
    </Authenticated>
</template>

<style lang="scss">
// header {
//     display: flex;
//     justify-content: center;
// }

// .p-menubar {
//     max-width: 1600px;
//     margin: 0 auto;
//     border: 0;
//     border-radius: 0;
// }

// main {
//     max-width: 1600px;
//     margin: 0 auto;
// }
</style>