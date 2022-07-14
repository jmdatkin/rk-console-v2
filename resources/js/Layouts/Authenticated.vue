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
            <!-- <main> -->
                <slot />
            <!-- </main> -->
        </div>

    </App>
</template>

<style lang="scss">
.app-wrapper {
    // padding: 10px;
}

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