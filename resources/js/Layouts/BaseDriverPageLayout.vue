<script setup>
// import Authenticated from './Authenticated';
import DriverLayout from './DriverLayout';
import Panel from 'primevue/panel';
import Divider from 'primevue/divider';
import Breadcrumb from 'primevue/breadcrumb';
import { useBreadcrumb } from '@/hooks'

</script>

<template>
    <DriverLayout>
        <section class="p-4 md:py-6 md:px-5 lg:px-8 xl:px-12">
        <!-- <section class="p-8"> -->
            <!-- <span class="page-header mb-8"> -->
                <h4>
                    <!-- Resource -->
                    <slot name="subheader"></slot>
                </h4>
            <h1 class="mb-4 lg:text-5xl tracking-tight">
                <slot name="header"></slot>
            </h1>
            <!-- </span> -->
            <slot></slot>
        </section>
    </DriverLayout>
</template>

<style lang="scss">
// .page-header {
//     font-weight: 600;
//     font-size: 2rem;
// }
</style>