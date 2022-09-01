<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import RouteRecipientsTable from '@/Components/Dashboard/RouteRecipientsTable';
import Card from 'primevue/card';
import moment from 'moment';
import { Link, Head } from '@inertiajs/inertia-vue3';
import Panel from 'primevue/panel';
import RecipientInfo from '@/Components/RecipientInfo';
import DriverInfo from '@/Components/DriverInfo';
import { Inertia } from '@inertiajs/inertia';
import TextClock from '@/Components/TextClock';
import { ref } from 'vue';

import { DateAdapter } from '../../util';
import RouteDriverTable from '../../Components/DriversByRoute/RouteDriverTable.vue';

defineProps(['routeDriver_data', 'routeRecipient_data', 'stats'])

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
                <!-- <h3>{{ moment.tz().utcOffset(-240).format("dddd DD MMM YYYY hh:mm A") }}</h3> -->
                <TextClock />
            </div>
        </div>
        <div class="grid">

            <div class="col-12 2xl:col-6">
            <!-- <div class="col-12"> -->
                <Panel>
                    <template #header>
                        <span>
                            <i class="pi pi-car"></i>
                            Today's Drivers
                        </span>
                    </template>
                    <!-- <RouteDriversTable :onSelect="openDriverDialog" :value="routeDriver_data"
                        :date="DateAdapter.make(moment.tz().utcOffset(-240))"></RouteDriversTable> -->
                        <RouteDriverTable :data="routeDriver_data"
                        :date="DateAdapter.make(moment.tz().utcOffset(-240))"></RouteDriverTable>
                </Panel>
            </div>
            <div class="col-12 2xl:col-6">
            <!-- <div class="col-12"> -->
                <Panel>
                    <template #header>
                        <span>
                            <i class="pi pi-box"></i>
                            Today's Recipients
                        </span>
                    </template>
                    <RouteRecipientsTable :onSelect="openRecipientDialog" :value="routeRecipient_data"
                        :date="DateAdapter.make(moment.tz().utcOffset(-240))">
                    </RouteRecipientsTable>
                </Panel>
            </div>
        </div>

        <div class="grid">
            <div class="col-12 md:col-6 lg:col-4">
                <Card>
                    <template #content>
                <div class="flex flex-col">
                    <span>
                {{ stats.recipients.total }} total recipients
                    </span>
                    <span>
                {{ stats.recipients.createdThisWeek }} added this week
                    </span>
                </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6 lg:col-4">
                <Card>
                    <template #content>
                <div class="flex flex-col">
                    <span>
                {{ stats.drivers.total }} total drivers
                    </span>
                    <span>
                {{ stats.drivers.createdThisWeek }} added this week
                    </span>
                </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6 lg:col-4">
                <Card>
                    <template #content>
                <div class="flex flex-col">
                    <span>
                {{ stats.person.total }} total people
                    </span>
                    <span>
                {{ stats.person.createdThisWeek }} added this week
                    </span>
                </div>
                    </template>
                </Card>
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
