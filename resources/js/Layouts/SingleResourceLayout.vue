<script setup>
import AuthenticatedVue from './Authenticated.vue';
import Card from 'primevue/card';
</script>

<template>
    <AuthenticatedVue>
        <div class="container w-full m-auto flex justify-content-center">
            <div class="content w-8 sm:w-full">
                <slot />
            </div>
        </div>
    </AuthenticatedVue>
</template>

<style lang="scss" scoped>
.card {
    line-height: 2;
}
</style>