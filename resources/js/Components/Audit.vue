<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import BasePageLayout from '@/Layouts/BasePageLayout';
import moment from 'moment';
import { computed } from 'vue';
import InfoItem from './InfoItem.vue';

const props = defineProps(['data'])

// const tableData = (audit) => {
//     return Object.entries(audit.old_values).map((entry) => {
//         let [key, val] = entry;
//         return {
//             attribute: key,
//             old_value: val,
//             new_value: audit.new_values[key]
//         };
//     });
// };
const tableData = computed(() => {
    let audit = props.data;
    return Object.entries(audit.new_values).map((entry) => {
        let [key, val] = entry;
        return {
            attribute: key,
            old_value: audit.new_values[key],
            new_value: val
            // old_value: val,
            // new_value: audit.new_values[key]
        };
    });
});

const formattedDate = computed(() => {
    return moment(props.data.created_at).format("YYYY-MM-DD hh:mm:ss A");
});

const formattedType = computed(() => {
    // return props.data.auditable_type.slice(
    //     props.data.auditable_type.indexOf('App\\Models\\')
    // );
        return props.data.auditable_type.slice('App\\Models\\'.length);
});
</script>

<template>
    <!-- <div class="audit-container flex flex-col">
        <strong>{{ formattedDate }}</strong>
    <div class="flex">
        <div>
            {{ data.user.firstName }} {{ data.user.lastName }} changed:
        </div>
        <div>
            <DataTable :value="tableData(data)"
            class="p-datatable-sm"    
            >
                <Column header="Attribute" field="attribute"></Column>
                <Column header="Old Value" field="old_value"></Column>
                <Column header="New Value" field="new_value"></Column>
            </DataTable>
        </div>
    </div>
    </div> -->
    <div class="p-2">
    <div class="grid">
        <strong>{{ formattedDate }}</strong>
    </div>
    <div class="grid">
        <div class="col-12 md:col-6">
            <InfoItem title="User">
            {{ data.user.firstName }} {{ data.user.lastName }} {{ data.event }}:
            </InfoItem>
            <InfoItem title="Resource">
                {{ formattedType }}
            </InfoItem>

        </div>
        <div class="col-12 md:col-6">
            <InfoItem v-if="tableData.length > 0" title="Data">
            <DataTable :value="tableData"
            class="p-datatable-sm p-datatable-audit"    
            responsiveLayout="scroll"
            >
                <Column header="Attribute" field="attribute"></Column>
                <Column header="Old Value" field="old_value"></Column>
                <Column header="New Value" field="new_value"></Column>
            </DataTable>
            </InfoItem>

        </div>
    </div>

    </div>
</template>

<style lang="scss">
html .p-datatable-audit td {
    background: transparent !important;
    border-color: black;
}

html .p-datatable-audit {
    border: solid 1px var(--gray-300);
}
</style>