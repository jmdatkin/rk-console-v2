<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import Divider from 'primevue/divider';
import Card from 'primevue/card';
import Panel from 'primevue/panel';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Button from 'primevue/button';
import PersonInfo from '@/Components/PersonInfo';
import { ref } from 'vue';

const props = defineProps(['data']);
</script>

<template>
    <SingleResourceLayout>

        <Head :title="`${data.firstName} ${data.lastName}`"></Head>
        <Button label="Back" icon="pi pi-chevron-left" type="button" class="p-button-text"
            @click="() => Inertia.visit(route('datatables.personnel'))"></Button>
        <Card class="mt-2">
            <template #content>
                <PersonInfo :data="data"></PersonInfo>
            </template>
        </Card>
    </SingleResourceLayout>
</template>