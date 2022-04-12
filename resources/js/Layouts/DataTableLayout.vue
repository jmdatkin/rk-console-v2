<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0">

            <slot></slot>
        </div>
    </AuthenticatedLayout>
</template>
