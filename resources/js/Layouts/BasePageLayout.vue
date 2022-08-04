<script setup>
// import Authenticated from './Authenticated';
import AdminLayout from './AdminLayout';
import Panel from 'primevue/panel';
import Divider from 'primevue/divider';
import Breadcrumb from 'primevue/breadcrumb';
import { useBreadcrumb } from '@/hooks'

</script>

<template>
    <AdminLayout>
        <section class="p-8">
            <!-- <span class="page-header mb-8"> -->
            <h1 class="mb-4">
                <slot name="header"></slot>
            </h1>
            <!-- </span> -->
            <slot></slot>
        </section>
    </AdminLayout>
</template>

<style lang="scss">
// .page-header {
//     font-weight: 600;
//     font-size: 2rem;
// }
</style>