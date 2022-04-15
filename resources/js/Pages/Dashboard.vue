<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Card from 'primevue/card';
import { Link, Head } from '@inertiajs/inertia-vue3';
</script>

<template>

    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between p-6 bg-white border-b border-gray-200">
                        <Link class="p-card-link" href="/datatables/recipients">
                        <Card>
                            <template #title>
                                Recipients
                            </template>
                            <template #content>
                                View and modify recipient records.
                            </template>
                        </Card>
                        </Link>
                        <Link class="p-card-link" href="/datatableclass=p-card-link">
                        <Card>
                            <template #title>
                                Drivers
                            </template>
                            <template #content>
                                View and modify driver records.
                            </template>
                        </Card>
                        </Link>
                        <Link class="p-card-link" href="/datatableclass=p-card-link">
                        <Card>
                            <template #title>
                                Routes
                            </template>
                            <template #content>
                                View and modify route records.
                            </template>
                        </Card>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style lang="scss">
.p-card-link {
    flex-grow: 1;
    align-items: stretch;
    margin: 1rem;
}

.p-card-link div.p-card:hover {
    background-color: var(--surface-100);
}
</style>
