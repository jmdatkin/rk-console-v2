<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Card from 'primevue/card';
import Divider from 'primevue/divider';
import { Link, Head } from '@inertiajs/inertia-vue3';
import CardLink from '@/Components/CardLink';
import Panel from 'primevue/panel';
</script>

<template>

    <Head title="Dashboard" />

    <BasePageLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="grid">
            <div class="col-6">
                <Panel header="Resources">
                    <ul>
                        <li>Recipients</li>
                        <li>Drivers</li>
                        <li>Routes</li>
                        <li>Personnel</li>
                        <li>Agencies</li>
                    </ul>
                </Panel>
            </div>
            <div class="col-6">
                <Panel>

                </Panel>
            </div>
        </div>
        
    </BasePageLayout>
</template>

<style scoped lang="scss">
.p-dashboard-card {
    flex-grow: 1;
    align-items: stretch;
    height: 100%;
}

h3 {
    font-size: 1.25rem;
    font-weight: 500;
}
</style>
