<script setup>
// import Authenticated from './Authenticated';
import AdminLayout from './AdminLayout';
import Panel from 'primevue/panel';
import Divider from 'primevue/divider';
</script>

<template>
    <!-- <Authenticated> -->
    <AdminLayout>
        <section>
            <Panel>
                <template #header>
                    <span class="page-header">
                        <h3>
                        <slot name="header"></slot>
                        </h3>
                    </span>
                </template>
                <slot></slot>
            </Panel>
        </section>
    </AdminLayout>
    <!-- </Authenticated> -->
</template>

<style lang="scss">
// .page-header {
//     font-weight: 600;
//     font-size: 2rem;
// }
</style>