<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Panel from 'primevue/panel';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import { propsToAttrMap } from '@vue/shared';

const props = defineProps(['title', 'onSelect', 'data']);

const confirm = useConfirm();
const toast = useToast();

const deleteAssignment = function (row) {
    console.log(row.data);
    confirm.require({
        message: 'Are you sure you want to delete this assignment?',
        header: 'Clear Assignment',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
            axios.patch(route('driver.deassign', { driver_id: row.data.pivot.driver_id, route_id: row.data.pivot.route_id, weekday: row.data.pivot.weekday }))
                .then(
                    () => {
                        toast.add({ severity: 'success', summary: 'Successful', detail: 'Assignment successfully deleted.', life: 3000 });
                        Inertia.reload({ only: ['data'] });
                    },
                    () => {
                        toast.add({ severity: 'info', summary: 'Cancelled', detail: 'Delete operation cancelled by user.', life: 3000 });
                    }
                );
        },
        reject: () => {

        }
    });
};
</script>

<template>
    <div class="flex flex-col">
        <!-- <span class="p-info-item-header">{{ title }}</span> -->
        <Panel :header="title">
            <DataTable class="p-datatable-sm" :value="data" :showGridlines="true">
                <Column field="id" header="id"></Column>
                <Column field="name" header="Route Name"></Column>
                <Column field="notes" header="Notes"></Column>
                <Column style="width:10%; min-width:4rem" bodyStyle="text-align:center">
                    <template #body="rowData">
                        <!-- {{ rowData }} -->
                        <Button icon="pi pi-trash" class="p-button-rounded p-button-secondary p-button-text"
                            @click="() => deleteAssignment(rowData)" />
                    </template>
                </Column>
            </DataTable>
            <Button class="p-button-text p-button-sm" @click="onSelect">Select Route</Button>
        </Panel>
    </div>
</template>

<style lang="scss">
.p-assign-delete {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: transparent;
    // background-color: var(--surface-100);
}

.p-assign-delete:hover {
    background-color: var(--surface-100);
}
</style>