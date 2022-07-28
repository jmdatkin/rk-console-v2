<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';
</script>

<template>
<Authenticated>
    <Header>
        <AdminMenuBar></AdminMenuBar>
    </Header>
    <main class="md:p-4 max-w-7xl mx-auto">
        <slot></slot>
    </main>
</Authenticated>
</template>

