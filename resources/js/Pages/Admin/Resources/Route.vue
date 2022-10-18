<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import Divider from 'primevue/divider';
import Card from 'primevue/card';
import Panel from 'primevue/panel';
import RouteInfo from '@/Components/RouteInfo';
import DriverAssignments from '@/Components/DriverAssignments';
import RecipientAssignments from '@/Components/RecipientAssignments';

const props = defineProps(['data', 'drivers', 'recipients']);
</script>
<template>
    <SingleResourceLayout>

        <Head :title="data.name"></Head>
        <!-- <Link class="p-router-link my-2" :href="route('datatables.recipients')">&lt; Recipients</Link> -->
        <Button label="Back" icon="pi pi-chevron-left" type="button" class="p-button-text"
            @click="() => Inertia.visit(route('datatables.routes'))"></Button>
        <Card class="mt-2">
            <template #content>
            <RouteInfo :data="data"></RouteInfo>
            <Divider />
            <Panel header="Driver Assignments" :toggleable="true" :collapsed="true">
                <DriverAssignments :driverData="drivers"></DriverAssignments>
            </Panel>
            <Panel header="Recipient Assignments" :toggleable="true" :collapsed="true">
                <RecipientAssignments :recipientData="recipients"></RecipientAssignments>
            </Panel>
            </template>
        </Card>
    </SingleResourceLayout>
</template>

<style lang="scss" scoped>
span {
    font-size: 12pt;
    font-weight: 600;
    text-transform: uppercase;
}
</style>