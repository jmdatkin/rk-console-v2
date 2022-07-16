<script setup>
import AdminLayout from './AdminLayout';
import Card from 'primevue/card';
</script>

<template>
    <AdminLayout>
        <div class="container w-full m-auto flex justify-content-center">
            <div class="content w-full md:w-8">
                <slot />
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>
.card {
    line-height: 2;
}
</style>