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
    <main>
        <slot></slot>
    </main>
</Authenticated>
</template>

<style lang="scss">
header {
    display: flex;
    justify-content: center;
}

.p-menubar {
    max-width: 1600px;
    margin: 0 auto;
    border: 0;
}

main {
    max-width: 1600px;
    margin: 0 auto;
    padding: 0 15px;
}
</style>