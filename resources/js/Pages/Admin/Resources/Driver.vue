<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import DriverInfo from '@/Components/DriverInfo';
import Divider from 'primevue/divider';
import Panel from 'primevue/panel';
import Button from 'primevue/button';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import DriverAssignments from '@/Components/DriverAssignments';
import { back } from '@/util';

import Card from 'primevue/card';
const props = defineProps(['data']);
</script>

<template>
    <SingleResourceLayout>
        <Head :title="`${data.person.firstName} ${data.person.lastName}`"></Head>
        <Button class="p-button-text" label="Back" icon="pi pi-chevron-left" type="button" @click="back"></Button>
        <Card class="mt-2">
            <template #content>
                <DriverInfo :data="data"></DriverInfo>
                <Divider />
                <Panel header="Route Assignments" :toggleable="true" :collapsed="false">
                    <DriverAssignments :driverData="data"></DriverAssignments>
                </Panel>

            </template>
        </Card>
    </SingleResourceLayout>
</template>
