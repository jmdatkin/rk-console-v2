<script setup>
import AuthenticatedVue from './Authenticated.vue';
import Card from 'primevue/card';
</script>

<template>
    <AuthenticatedVue>
        <div class="container w-full flex justify-content-center">
            <div class="content w-6">
                <Card>
                    <template #content>
                        <slot />
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedVue>
</template>
