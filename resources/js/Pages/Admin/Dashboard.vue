<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import RouteRecipientsTable from '@/Components/Dashboard/RouteRecipientsTable';
import Badge from 'primevue/badge';
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
import DBLockIndicator from '../../Components/Dashboard/DBLockIndicator.vue';
import DBStatusWidget from '../../Components/Dashboard/DBStatusWidget.vue';
import InfoItem from '../../Components/InfoItem.vue';

defineProps(['routeDriver_data',
    'routeRecipient_data',
    'stats',
    'lockIn',
    'lockOut',
    'messages'])

const recipientData = ref([]);
const driverData = ref([]);

const recipientDialogOpen = ref(false);
const driverDialogOpen = ref(false);

const openRecipientDialog = function (row) {
    recipientData.value = row.data;
    recipientDialogOpen.value = true;
};

const viewRecipient = function (id) {
    Inertia.visit(route('recipient.show', id));
};

const openDriverDialog = function (row) {
    driverData.value = row.data.driver;
    driverDialogOpen.value = true;
};

const viewDriver = function (id) {
    Inertia.visit(route('driver.show', id));
};

</script>

<template>

    <Head title="Dashboard" />

    <BasePageLayout :messages="messages">
        <!-- Driver Dialog -->
        <Dialog :modal="true" :dismissableMask="true" closeOnEscape="true" v-model:visible="driverDialogOpen">
            <template #header>
                &nbsp;
            </template>
            <DriverInfo :data="driverData"></DriverInfo>
            <template #footer>
                <Button class="p-button-text" label="View Resource" icon="pi pi-chevron-right" iconPos="right"
                    @click="() => viewDriver(driverData.id)"></Button>
            </template>
        </Dialog>
        <!-- Recipient Dialog -->
        <Dialog :modal="true" :dismissableMask="true" closeOnEscape="true" v-model:visible="recipientDialogOpen">
            <template #header>
                &nbsp;
            </template>
            <RecipientInfo :data="recipientData"></RecipientInfo>
            <template #footer>
                <Button class="p-button-text" label="View Resource" icon="pi pi-chevron-right" iconPos="right"
                    @click="() => viewRecipient(recipientData.id)"></Button>
            </template>
        </Dialog>
        <template #header>
            Dashboard
        </template>
        <div class="grid">
            <div class="col-12">
                <TextClock />
            </div>
        </div>
        <div class="grid">
            <div class="col-12 xl:col-9">
                <div class="grid">

                    <div class="col-12 2xl:col-6">
                        <Panel>
                            <template #header>
                                <span>
                                    <i class="pi pi-car"></i>
                                    Today's Drivers
                                </span>
                            </template>
                            <RouteDriverTable :data="routeDriver_data"
                                :date="DateAdapter.make(moment.tz().utcOffset(-240))"></RouteDriverTable>
                        </Panel>
                    </div>
                    <div class="col-12 2xl:col-6">
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

            </div>

            <div class="col-12 xl:col-3">
                <div class="grid">
                    <div class="col-12">
                        <div class="flex flex-row flex-wrap space-y-2">
                            <div class="basis-full">
                                <Card>
                                    <template #content>
                                        <div class="flex flex-col">
                                            <span>
                                                <DBLockIndicator :status="stats.isAppLocked" :lockIn="lockIn" :lockOut="lockOut"></DBLockIndicator>
                                            </span>
                                        </div>
                                    </template>
                                </Card>
                            </div>
                            <div class="basis-full">
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
                            <div class="basis-full">
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
                            <div class="basis-full">
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
                    </div>
                </div>
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
