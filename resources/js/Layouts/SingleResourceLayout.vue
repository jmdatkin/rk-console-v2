<script setup>
import AuthenticatedVue from './Authenticated.vue';
import Panel from 'primevue/panel';
</script>

<template>
    <AuthenticatedVue>
        <div class="container w-full flex justify-content-center">
            <div class="content w-6">
                <Panel>
                    <slot />
                </Panel>
            </div>
        </div>
    </AuthenticatedVue>
</template>
