<script setup>
import MenuBar from 'primevue/menubar';
import ApplicationLogo from './ApplicationLogo';
import Button from 'primevue/button';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { driverMenuItems } from '../constants';

const items = ref(driverMenuItems);
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
    </template>
</MenuBar>
</template>

<style lang="scss">
</style>