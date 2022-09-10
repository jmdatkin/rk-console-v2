<script setup>
import { computed } from 'vue';
import InfoItem from './InfoItem.vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import moment from 'moment';
import FullscreenDataTable from './FullscreenDataTable.vue';

const props = defineProps(['job']);

// const jobClass = computed(() => props.job.job_name.split(':')[0]);
const jobClass = computed(() => props.job.job_name.split(':')[0]);

// const jobAction = computed(() => props.job_name.split(':')[1]);
const jobAction = computed(() => props.job.job_name.split(':')[1]);

const jobIcon = computed(() => {
    // switch (jobClass) {
    //     case 'recipient':
    //         return 'pi pi-box';
    //     case 'driver':
    //         return 'pi pi-car';
    //     case 'person':
    //         return 'pi pi-user';
    //     case 'route':
    //         return 'pi pi-map';
    //     case 'agency':
    //         return 'pi pi-building';
    //     default:
    //         return '';
    // }
    return {
        'recipient': 'pi pi-box'
    }[jobClass.value] || '';
});

const actionString = computed(() => {
    let str;
    let payload = props.job.payload;

    let action = jobAction.value;
    let _class = jobClass.value;

    if (action === 'update') {
        str = `Update ${_class} with id ${payload[0]}`;
    } else if (action === 'destroy') {
        str = `Delete ${_class} with id ${payload[0]}`;
    } else if (action === 'create') {
        str = `Create new ${_class}`;
    } else {
        str = '';
    }

    return str;
});

const createdAtFormat = computed(() => {
    return moment(props.job.created_at).format("YYYY-MM-DD HH:mm:ss");
});

const payloadTableData = computed(() => {
    return Object.entries(props.job.payload[1] || props.job.payload).map(entry => {
        return {
            "attribute": entry[0],
            "value": entry[1]
        }
    });
});
</script>

<template>
    <div class="pending-job flex bg-white rounded border shadow-sm items-center">
        <div class="start border-r h-full">
            <div class="p-4 h-full">
                <InfoItem :title="jobAction" class="mb-1">
                </InfoItem>
            </div>
        </div>
        <div class="center flex-grow">
            <div class="p-4">
                <div class="flex flex-grow items-center space-between space-x-4">
                    <div class="flex flex-col">
                        <span class="text-gray-500">
                            {{ createdAtFormat }}
                        </span>
                        <span class="mb-2">
                            {{ actionString }}
                        </span>
                    </div>
                    <div class="flex-grow" v-if="jobAction === 'update' || jobAction === 'create'">
                        <DataTable style="" class="p-datatable-sm" :showGridlines="true" :value="payloadTableData"
                            responsiveLayout="scroll">
                            <Column header="Key" field="attribute" style="max-width: 2rem;"></Column>
                            <Column header="Value" field="value"></Column>
                        </DataTable>
                    </div>
                </div>

            </div>
        </div>
        <div class="start border-l h-full">
            <div class="p-4 h-full">
                <div class="space-x-1">
                    <Button icon="pi pi-check" class="p-button-rounded p-button-outlined"></Button>
                    <Button icon="pi pi-trash" class="p-button-danger p-button-rounded p-button-outlined"></Button>
                </div>

            </div>
        </div>

    </div>
    <!-- <Button label="Commit Job" icon="pi pi-check" class="p-button-rounded p-button-outlined" ></Button>
        <Button label="Discard Job" icon="pi pi-trash" class="p-button-danger p-button-rounded p-button-outlined"></Button> -->
</template>

<style lang="scss" scoped>

</style>