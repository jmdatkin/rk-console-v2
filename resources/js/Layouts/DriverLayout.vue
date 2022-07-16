<script setup>
import Authenticated from './Authenticated';
import Header from '../Components/Header.vue';
import DriverMenuBar from '../Components/DriverMenuBar.vue';
</script>

<template>
<Authenticated>
    <Header>
        <DriverMenuBar></DriverMenuBar>
    </Header>
    <main class="md:p-4">
        <slot></slot>
    </main>
</Authenticated>
</template>

<style lang="scss">
header {
    display: flex;
    justify-content: center;
    background-color: red;
}

.p-menubar {
    max-width: 1600px;
    margin: 0 auto;
    border: 0;
}

main {
    max-width: 1600px;
    margin: 0 auto;
}
</style>