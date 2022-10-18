<script setup>
import DriverLayout from './DriverLayout';
</script>

<template>
    <DriverLayout>
        <section class="p-4 md:py-6 md:px-5 lg:px-8 xl:px-12">
                <h4>
                    <!-- Resource -->
                    <slot name="subheader"></slot>
                </h4>
            <h1 class="mb-4 lg:text-5xl tracking-tight">
                <slot name="header"></slot>
            </h1>
            <slot></slot>
        </section>
    </DriverLayout>
</template>

<style lang="scss">
</style>