<script setup>
import OverlayPanel from 'primevue/overlaypanel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Card from 'primevue/card';
import { ref } from 'vue';

const props = defineProps(['callback', 'data']);

const overlay = ref();
const toggle = function (e) {
    overlay.value.toggle(e);
};

</script>

<template>

    <div class="weekday">
        <OverlayPanel appendTo="body" ref="overlay">
            <slot name="overlay"></slot>
        </OverlayPanel>
        <div class="weekday-inner">
            <div class="start">
                <a class="weekday-header" @click="callback">
                    <slot name="head" />
                </a>

            </div>
            <div class="end">
                <slot name="body">

                    <DataTable class="p-datatable-sm" :value="props.data">
                        <Column field="id" header="id"></Column>
                        <Column field="name" header="name"></Column>
                        <Column field="notes" header="notes"></Column>
                    </DataTable>

                </slot>
            </div>
        </div>
        <!-- <Card>
            <template #title>
                <a @click="callback">
                    <slot name="head" />
                </a>
            </template>
            <template #content>
                <DataTable :value="props.data">
                    <Column field="id" header="id"></Column>
                    <Column field="name" header="name"></Column>
                    <Column field="notes" header="notes"></Column>
                </DataTable>
            </template>
        </Card> -->
    </div>

</template>

<style scoped lang="scss">
.weekday {
    flex-basis: calc((100% / 7) - 1px);
    flex-grow: 1;
    border: solid 1px var(--gray-800);
    // padding: 5px;
}

.weekday:nth-child(n+2) {
    border-left: 0;
}

.weekday-inner {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    // justify-content: space-between;
}

.weekday-inner .start {
    border-bottom: solid 1px var(--gray-800);
    text-align: center;
}

.weekday-header {
    display: block;
    padding: 5px;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.weekday-header:hover {
    background-color: var(--gray-200);
}
</style>