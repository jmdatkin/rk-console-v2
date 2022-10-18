<script setup>
import AdminLayout from './AdminLayout';
import Card from 'primevue/card';
import BasePageLayout from './BasePageLayout.vue';
</script>

<template>
    <BasePageLayout>
        <div class="container w-full m-auto flex justify-content-center">
            <div class="content w-full md:w-8">
                <slot />
            </div>
        </div>
    </BasePageLayout>
</template>

<style lang="scss" scoped>
.card {
    line-height: 2;
}
</style>