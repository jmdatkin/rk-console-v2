<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import Divider from 'primevue/divider';
import Card from 'primevue/card';
import Panel from 'primevue/panel';
import { Link, Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Button from 'primevue/button';
import InputSwitch from 'primevue/inputswitch';
import RecipientInfo from '@/Components/RecipientInfo';
import RecipientAssignments from '@/Components/RecipientAssignments';
import Toolbar from 'primevue/toolbar';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import { ref } from 'vue';
import { back } from '@/util';
import RecipientService from '../../../Service/RecipientService';

const props = defineProps(['data']);

const confirm = useConfirm();
const toast = useToast();

const paused = ref(props.data.paused);
const editing = ref(false);

const onPausedChange = (e) => {
    confirm.require({
        message: `Are you sure you want to ${paused.value ? 'pause' : 'unpause'} recipient ${props.data.id}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
        accept: () => {
            // console.log(e);
            RecipientService.edit(props.data.id, {paused: paused.value});
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'Cancelled', detail: 'Delete operation cancelled by user.', life: 3000 });
        }
    })
}

</script>

<template>
    <SingleResourceLayout>

        <Head :title="`${data.person.firstName} ${data.person.lastName}`"></Head>
        <!-- <Link class="p-router-link my-2" :href="route('datatables.recipients')">&lt; Recipients</Link> -->
        <!-- <Button label="Back" icon="pi pi-chevron-left" type="button" class="p-button-text" @click="() => Inertia.visit(route('datatables.recipients'))"></Button> -->
        <Toolbar>
            <template #start>
                <Button label="Back" icon="pi pi-chevron-left" type="button" class="p-button-text"
                    @click="back"></Button>
            </template>
            <template #end>
                <!-- <InputSwitch v-model="editing"></InputSwitch> -->


            </template>
        </Toolbar>
        <Card class="mt-2">
            <template #header>
            </template>
            <template #content>
                <RecipientInfo :editing="editing" :data="data"></RecipientInfo>
                <InputSwitch label="Paused" v-model="paused" @change="onPausedChange"></InputSwitch>
                <Divider />
                <Panel class="p-text-secondary" header="Route Assignments" :toggleable="true" :collapsed="false">
                    <RecipientAssignments :recipientData="data"></RecipientAssignments>
                </Panel>
            </template>
        </Card>
    </SingleResourceLayout>
</template>

<style lang="scss">
.p-toolbar {
    padding: 0;
    border: 0;
    background-color: transparent;
}
</style>