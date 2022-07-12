<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import Divider from 'primevue/divider';
import Card from 'primevue/card';
import Panel from 'primevue/panel';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Button from 'primevue/button';
import AgencyInfo from './AgencyInfo';
import { ref } from 'vue';

const props = defineProps(['data']);
</script>

<template>
    <SingleResourceLayout>
        <Head :title="`${data.name}`"></Head>
        <!-- <Link class="p-router-link my-2" :href="route('datatables.recipients')">&lt; Recipients</Link> -->
        <Button label="Back" icon="pi pi-chevron-left" type="button" class="p-button-text" @click="() => Inertia.visit(route('datatables.recipients'))"></Button>
        <Card class="mt-2">
            <template #content>
                <RecipientInfo :data="data"></RecipientInfo>
                <Divider />
                <Panel class="p-text-secondary" header="Route Assignments" :toggleable="true" :collapsed="false">
                    <AgencyAssignments :agencyData="data"></AgencyAssignments>
                </Panel>
            </template>
        </Card>
    </SingleResourceLayout>
</template>