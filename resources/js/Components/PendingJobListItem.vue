<script setup>
import { computed } from 'vue';
import InfoItem from './InfoItem.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import moment from 'moment';
import AccordionTab from 'primevue/accordiontab';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';
import FullscreenDataTable from './FullscreenDataTable.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['job']);

const confirm = useConfirm();
const toast = useToast();

const actionString = computed(() => {
    let str;
    let payload = props.job.payload;

    let id = props.job.resource_id;
    let action = props.job.job_action;
    let type = props.job.resource_type;

    if (action === 'update') {
        str = `Update ${type} with id ${id}`;
    } else if (action === 'destroy') {
        str = `Delete ${type} with id ${id}`;
    } else if (action === 'create') {
        str = `Create new ${type}`;
    } else {
        str = '';
    }

    return str;
});

const createdAtFormat = computed(() => {
    return moment(props.job.created_at).format("YYYY-MM-DD HH:mm:ss");
});

const payloadTableData = computed(() => {
    return Object.entries(props.job.payload).map(entry => {
        return {
            "attribute": entry[0],
            "value": entry[1]
        }
    });
});

const doCommit = function () {
    confirm.require({
        message: `Are you sure you want to commit job with id ${props.job.id}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-success',
        accept: () => {
            axios.post(route('jobs.commit', props.job.id))
                .then(
                    (res) => {
                        toast.add({ severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                        Inertia.reload();
                    },
                    () => {
                        toast.add({ severity: 'error', summary: 'Error', detail: res, life: 3000 });
                    }
                );
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'Cancelled', detail: 'Commit operation cancelled by user.', life: 3000 });
        }
    });
};

const doDestroy = function () {
    confirm.require({
        message: `Are you sure you want to delete job with id ${props.job.id}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
        accept: () => {
            axios.post(route('jobs.destroy', props.job.id))
                .then(
                    (res) => {
                        toast.add({ severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                        Inertia.reload();
                    },
                    () => {
                        toast.add({ severity: 'error', summary: 'Error', detail: res, life: 3000 });
                    }
                );
        },
        reject: () => {
            toast.add({ severity: 'info', summary: 'Cancelled', detail: 'Delete operation cancelled by user.', life: 3000 });
        }
    });

}
</script>

<template>
    <AccordionTab>
        <div class="flex flex-grow items-center space-between space-x-4">
            <div class="flex flex-col">
                <span class="text-gray-500">
                    {{ createdAtFormat }}
                </span>
                <span class="mb-2">
                    {{ actionString }}
                </span>
            </div>
            <div class="flex-grow" v-if="props.job.job_action === 'update' || props.job.job_action === 'create'">
                <DataTable style="" class="p-datatable-sm" :showGridlines="true" :value="payloadTableData"
                    responsiveLayout="scroll">
                    <Column header="Key" field="attribute" style="max-width: 2rem;"></Column>
                    <Column header="Value" field="value"></Column>
                </DataTable>
            </div>
        </div>
    </AccordionTab>
</template>

<style lang="scss" scoped>

</style>