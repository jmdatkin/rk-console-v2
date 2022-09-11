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
    <div class="pending-job flex w-full items-center relative">
        <!-- <span class="text-gray-500 text-monospace absolute left-2 top-2">
            {{ job.id }}
        </span> -->
        <div class="start border-r h-full">
            <div class="px-4 h-full">
                <InfoItem :title="job.job_action" class="mb-1">
                </InfoItem>
            </div>
        </div>
        <div class="center flex-grow">
            <div class="px-4">
                <div class="flex flex-col">
                    <span>
                        <span>
                            {{ job.user.firstName }} {{ job.user.lastName }}
                        </span>
                        <span class="text-gray-500">
                            {{ createdAtFormat }}
                        </span>
                    </span>
                    <span class="mb-2">
                        {{ actionString }}
                    </span>
                </div>
            </div>
        </div>
        <div class="end border-l h-full">
            <div class="px-4 h-full">
                <div class="space-x-1">
                    <Button @click.stop="doCommit" icon="pi pi-check"
                        class="p-button-rounded p-button-outlined"></Button>
                    <Button @click.stop="doDestroy" icon="pi pi-trash"
                        class="p-button-danger p-button-rounded p-button-outlined"></Button>
                </div>

            </div>
        </div>
    </div>

</template>

<style lang="scss" scoped>

</style>