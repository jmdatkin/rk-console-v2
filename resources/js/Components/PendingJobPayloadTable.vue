<script setup>
import { computed } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
const props = defineProps(['job']);

const payloadTableData = computed(() => {
    return Object.entries(props.job.payload[0]).map(entry => {
        return {
            "attribute": entry[0],
            "value": entry[1]
        }
    });
});
</script>

<template>
    <div class="flex flex-grow items-center space-between">
        <div class="flex-grow" v-if="props.job.job_action === 'update' || props.job.job_action === 'create'">
            <DataTable style="" class="p-datatable-sm" :showGridlines="true" :value="payloadTableData"
                responsiveLayout="scroll">
                <Column header="Key" field="attribute"></Column>
                <Column header="Value" field="value"></Column>
            </DataTable>
        </div>
    </div>
</template>