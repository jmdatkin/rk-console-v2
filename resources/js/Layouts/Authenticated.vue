<script setup>
import App from './App';
import Header from '../Components/Header.vue';
import AdminMenuBar from '../Components/AdminMenuBar.vue';

</script>

<template>
    <App>
        <div class="app-wrapper">
            <!-- <Header>
                <AdminMenuBar></AdminMenuBar>
            </Header> -->

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>

    </App>
</template>

<style lang="scss">
.app-wrapper {
    // padding: 10px;
}

</style>