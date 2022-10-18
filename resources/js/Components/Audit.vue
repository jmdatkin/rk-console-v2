<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import moment from 'moment';
import { computed } from 'vue';
import InfoItem from './InfoItem.vue';

const props = defineProps(['data'])

const tableData = computed(() => {
    let audit = props.data;
    return Object.entries(audit.new_values).map((entry) => {
        let [key, val] = entry;
        return {
            attribute: key,
            old_value: audit.old_values[key],
            new_value: val
        };
    });
});

const formattedDate = computed(() => {
    return moment(props.data.created_at).format("YYYY-MM-DD hh:mm:ss A");
});

const formattedType = computed(() => {
        return props.data.auditable_type.slice('App\\Models\\'.length);
});
</script>

<template>
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