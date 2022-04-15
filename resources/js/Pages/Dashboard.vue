<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Card from 'primevue/card';
import Divider from 'primevue/divider';
import { Link, Head } from '@inertiajs/inertia-vue3';
import CardLink from '@/Components/CardLink';
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
                <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> -->
                <div class="flex flex-col">
                    <!-- <div class="flex justify-between"> -->
                    <div class="grid">
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Volunteers
                                </template>
                                <template #content>
                                    View and modify volunteer records.
                                </template>
                            </CardLink>
                        </div>
                        <div class="col"></div>
                        <!-- <CardLink class="p-dashboard-card" href="/datatables/recipients">
                            
                            <template #title>
                                Drivers
                            </template>
                            <template #content>
                                View and modify driver records.
                            </template>
                        </CardLink>
                        <CardLink class="p-dashboard-card" href="/datatables/recipients">
                            <template #title>
                                Routes
                            </template>
                            <template #content>
                                View and modify route records.
                            </template>
                        </CardLink> -->
                    </div>
                    <Divider />
                    <!-- <div class="flex justify-between"> -->
                    <div class="grid mb-4">
                        <div class="col-12">
                            <h3>Resources</h3>
                        </div>
                        <!-- <Divider>
                            <div class="inline-flex align-items-left">
                                <b>Resources</b>
                            </div>
                        </Divider> -->
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Recipients
                                </template>
                                <template #content>
                                    View and modify recipient records.
                                </template>
                            </CardLink>
                        </div>
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Drivers
                                </template>
                                <template #content>
                                    View and modify driver records.
                                </template>
                            </CardLink>
                        </div>
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Routes
                                </template>
                                <template #content>
                                    View and modify route records.
                                </template>
                            </CardLink>
                        </div>
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Agencies
                                </template>
                                <template #content>
                                    View and modify agency records.
                                </template>
                            </CardLink>
                        </div>
                    </div>
                    <Divider />
                    <div class="grid">
                        <div class="col-12">
                            <h3>Reports</h3>
                        </div>
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Driver Report
                                </template>
                                <template #content>
                                    Generate report for drivers.
                                </template>
                            </CardLink>
                        </div>
                        <div class="col-4">
                            <CardLink class="p-dashboard-card" href="/datatables/recipients">
                                <template #title>
                                    Meal Report
                                </template>
                                <template #content>
                                    Generate report for chefs/agencies.
                                </template>
                            </CardLink>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped lang="scss">
.p-dashboard-card {
    flex-grow: 1;
    align-items: stretch;
    // margin: 0.75rem;
    height: 100%;
}

h3 {
    font-size: 1.25rem;
    font-weight: 500;
}
</style>
