<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import RouteDriversTable from '@/Components/Dashboard/RouteDriversTable';
import RouteRecipientsTable from '@/Components/Dashboard/RouteRecipientsTable';
import moment from 'moment';
import Divider from 'primevue/divider';
import { Link, Head } from '@inertiajs/inertia-vue3';
import Panel from 'primevue/panel';
import RecipientInfo from '@/Components/RecipientInfo';
import DriverInfo from '@/Components/DriverInfo';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';

import { DateAdapter } from '../../util';

defineProps(['routeDriver_data', 'routeRecipient_data'])

const recipientData = ref([]);
const driverData = ref([]);

const recipientDialogOpen = ref(false);
const driverDialogOpen = ref(false);

const openRecipientDialog = function (row) {
    recipientData.value = row.data;
    recipientDialogOpen.value = true;
};

const viewRecipient = function(id) {
    Inertia.visit(route('recipient.show', id));
};

const openDriverDialog = function (row) {
    driverData.value = row.data.driver;
    driverDialogOpen.value = true;
};

const viewDriver = function(id) {
    Inertia.visit(route('driver.show', id));
};
</script>

<template>

    <Head title="Dashboard" />

    <BasePageLayout>
        <!-- Driver Dialog -->
        <Dialog :modal="true" :dismissableMask="true" closeOnEscape="true" v-model:visible="driverDialogOpen">
            <template #header>
                &nbsp;
            </template>
            <DriverInfo :data="driverData"></DriverInfo>
            <template #footer>
                <Button class="p-button-text" label="View Resource" icon="pi pi-chevron-right" iconPos="right" @click="() => viewDriver(driverData.id)"></Button>
            </template>
        </Dialog>
        <!-- Recipient Dialog -->
        <Dialog :modal="true" :dismissableMask="true" closeOnEscape="true" v-model:visible="recipientDialogOpen">
            <template #header>
                &nbsp;
            </template>
            <RecipientInfo :data="recipientData"></RecipientInfo>
            <template #footer>
                <Button class="p-button-text" label="View Resource" icon="pi pi-chevron-right" iconPos="right" @click="() => viewRecipient(recipientData.id)"></Button>
            </template>
        </Dialog>
        <template #header>
            <!-- <h2 class="font-semibold text-xl leading-tight mb-4"> -->
                Dashboard
            <!-- </h2> -->
        </template>
        <div class="grid">
            <div class="col-12">
                <h3>{{ moment().format("dddd DD MMM YYYY HH:mm:ss") }}</h3>
            </div>
        </div>
        <div class="grid">

            <div class="col-12 lg:col-6">
                <Panel>
                    <template #header>
                        <span>
                            <i class="pi pi-car"></i>
                            Today's Drivers
                        </span>
                    </template>
                    <RouteDriversTable :onSelect="openDriverDialog" :value="routeDriver_data"
                        :date="DateAdapter.make(Date.now())"></RouteDriversTable>
                </Panel>
            </div>
            <div class="col-12 lg:col-6">
                <Panel>
                    <template #header>
                        <span>
                            <i class="pi pi-box"></i>
                            Today's Recipients
                        </span>
                    </template>
                    <RouteRecipientsTable :onSelect="openRecipientDialog" :value="routeRecipient_data"
                        :date="DateAdapter.make(Date.now())">
                    </RouteRecipientsTable>
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
