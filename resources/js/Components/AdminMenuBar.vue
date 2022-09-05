<script setup>
import MenuBar from 'primevue/menubar';
import ApplicationLogo from './ApplicationLogo';
import Button from 'primevue/button';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { adminMenuItems } from '../constants';

const items = ref(adminMenuItems);
</script>

<template>
<MenuBar class="mb-2" :model="items">
    <template #start>
        <Link :href="route('dashboard')">
        <ApplicationLogo class="block h-9 w-auto" />
        </Link>
    </template>
    <template #end>
        <Button label="Profile" icon="pi pi-user" class="p-button-text p-button-plain"
            @click="() => Inertia.get(route('profile'))"></Button>
        <Button label="Log Out" class="p-button-text p-button-plain"
            @click="() => Inertia.post(route('logout'))"></Button>
        <!-- <Link :href="route('profile')" method="get" as="button">
    <i class="pi pi-user"></i>
        Profile
    </Link>
    <Link :href="route('logout')" method="post" as="button">
        Log Out
    </Link> -->
    </template>
</MenuBar>
</template>

<style lang="scss">
</style>