<script setup>
import App from './App';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';

</script>

<template>
    <App>
        <div class="app-wrapper">
                <slot />
        </div>

    </App>
</template>

<style lang="scss">
</style>