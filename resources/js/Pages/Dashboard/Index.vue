<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import DashboardTable from './DashboardTable';
import RouteRecipientsTable from './RouteRecipientsTable';
import moment from 'moment';
import Card from 'primevue/card';
import Divider from 'primevue/divider';
import { Link, Head } from '@inertiajs/inertia-vue3';
import CardLink from '@/Components/CardLink';
import { momentFormatString } from '../../util';

import Panel from 'primevue/panel';

defineProps(['routeDriver_data', 'routeRecipient_data'])
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
            <div class="col-12">
                <h3>{{ moment(Date.now()).format("dddd DD MMM YYYY") }}</h3>
            </div>
        </div>
        <div class="grid">
            <div class="col-12">
                <Panel>
                    <template #header>
                        Today's Drivers
                    </template>
                    <!-- <RouteRecipientsTable :date="moment(Date.now())"></RouteRecipientsTable> -->
                    <DashboardTable :value="routeDriver_data" :date="moment(Date.now()).format(momentFormatString)"></DashboardTable>
                </Panel>
            </div>
        </div>
        <div class="grid">
            <div class="col-12">
                <Panel>
                    <template #header>
                        Today's Recipients
                    </template>
                    <!-- <RouteRecipientsTable :date="moment(Date.now())"></RouteRecipientsTable> -->
                    <RouteRecipientsTable :value="routeRecipient_data" :date="moment(Date.now()).format(momentFormatString)"></RouteRecipientsTable>
                </Panel>
            </div>
        </div>
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
