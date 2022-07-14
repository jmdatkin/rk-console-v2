<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Button from 'primevue/button';
import Row from 'primevue/row';
import Dialog from 'primevue/dialog';
import ContextMenu from 'primevue/contextmenu';
import moment from 'moment';
// import { formatDate } from '@fullcalendar/common';
import { useConfirm } from 'primevue/useconfirm';
import { DateAdapter } from '../../util';
import { ref, onUpdated, onMounted, computed } from 'vue';

const props = defineProps(['date', 'openDateSelect']);

const rowClass = (data) => {
    return data.inException ? 'in-exception' : null;
};

const data = ref([]);
const getData = function () {
    let dateString = DateAdapter.make(props.date);
    axios.get(route('recipientsbyroute.data', { date: dateString}))
        .then(res => {
            data.value = res.data;
        });
};

onMounted(() => {
    getData();
});
</script>
<template>

    <DataTable :value="data" rowGroupMode="rowspan" :paginator="true" :rowClass="rowClass" :rows="10" responsiveLayout="scroll"
        columnResizeMode="fit" :showGridlines="true" groupRowsBy="routeName">
        <template #header>
            <Button label="Change Date" icon="pi pi-calendar" @click="openDateSelect" />
            {{ date }}
        </template>
        <Column :sortable="true" header="Route" field="routeName">
        </Column>
        <Column :sortable="true" field="id" header="id" style="max-width: 10%; text-align: center">
        </Column>
        <Column :sortable="true" header="Agency" field="agency.name">
        </Column>
        <Column :sortable="true" header="First Name" field="person.firstName">
        </Column>
        <Column :sortable="true" header="Last Name" field="person.lastName">
        </Column>
        <Column :sortable="true" header="E-mail Address" field="person.email">
        </Column>
        <Column :sortable="true" header="Home Phone" field="person.phoneHome">
        </Column>
        <Column :sortable="true" header="Cell Phone" field="person.phoneCell">
        </Column>
        <Column :sortable="true" header="Num. Meals" field="numMeals">
        </Column>
        <Column :sortable="true" header="Notes" field="person.notes">
        </Column>
    </DataTable>
    <ContextMenu :model="menuModel" ref="cm"></ContextMenu>
</template>

<style lang="scss" scoped>
a {
    cursor: pointer;
}

a:hover {
    text-decoration: underline;
}

.in-exception {
    // color: var(--red-800);
}


::v-deep .in-exception {
    background-color: var(--red-200) !important;
}
</style>