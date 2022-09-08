<script setup>
import AdminLayout from './AdminLayout';
import Message from 'primevue/message';

defineProps(['messages']);
</script>

<template>
    <AdminLayout>
        <section class="p-0 md:py-4 md:px-5 lg:px-8 xl:px-12">
        <Message v-for="message of messages" :severity="message.severity" :key="message.content">
        {{message.content}}
        </Message>
                <h4>
                    <!-- Resource -->
                    <slot name="subheader"></slot>
                </h4>
            <h1 class="mb-4 px-4 md:p-0 md:text-5xl tracking-tight">
                <slot name="header"></slot>
            </h1>
            <slot></slot>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
</style>