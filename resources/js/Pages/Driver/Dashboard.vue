<script setup>
import DriverLayout from '@/Layouts/DriverLayout';
import Dialog from 'primevue/dialog';
import moment from 'moment';
import Divider from 'primevue/divider';
import { Link, Head } from '@inertiajs/inertia-vue3';
import Panel from 'primevue/panel';
import { ref } from 'vue';
import { DateAdapter } from '../../util';
import RouteRecipientsTable from '../../Components/Dashboard/RouteRecipientsTable.vue';
import SingleRouteRecipientTable from '../../Components/DriverDashboard/SingleRouteRecipientTable.vue';
import RecipientInfo from '../../Components/RecipientInfo.vue';

defineProps(['data']);

const recipientDialogOpen = ref(false);
const selectedRecipient = ref();
const dialog = ref();

const onRowSelect = function(row) {
    selectedRecipient.value = row.data;
    recipientDialogOpen.value = true;
};
</script>

<template>
<DriverLayout>
    <Head title="Dashboard" />
    <Dialog ref="dialog" :modal="true" :dismissableMask="true" :closeOnEscape="true"
    v-model:visible="recipientDialogOpen"
    >
        <RecipientInfo :data="selectedRecipient"></RecipientInfo>
    </Dialog>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight mb-4">
                Dashboard
            </h2>
        </template>
        <div class="grid">
            <div class="col-12">
                <h3>{{ moment().format("dddd DD MMM YYYY HH:mm:ss") }}</h3>
            </div>
        </div>
        <div class="grid">

            <div class="col-12">
                <Panel>
                    <template #header>
                        <span>
                            <i class="pi pi-box"></i>
                            Today's Recipients
                        </span>
                    </template>
                    <div class="mb-4" v-for="route in data">
                    <h4>{{ route.name }}</h4>
                    <SingleRouteRecipientTable :data="route.recipients"
                    :onRowSelect="onRowSelect"
                    ></SingleRouteRecipientTable>
                    </div>
                </Panel>
            </div>
        </div>
</DriverLayout>
</template>

<style scoped lang="scss">
.p-dashboard-card {
    flex-grow: 1;
    align-items: stretch;
    height: 100%;
}
</style>
