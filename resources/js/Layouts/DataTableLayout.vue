<script setup>
import { ref } from 'vue';
// import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BasePageLayout from '@/Layouts/BasePageLayout';
import ConfirmDialog from 'primevue/confirmdialog';
import Panel from 'primevue/panel';
</script>

<template>
    <BasePageLayout>
        <template #header>
            Table
            <slot name="header"></slot>
        </template>
        <!-- <template #header>
            <slot name="header"></slot>
        </template> -->
        <slot></slot>
        <!-- OLD
        <div class="relative flex pt-0 justify-center min-h-screen bg-gray-100 sm:pt-2">
            <div class="flex flex-col px-0 w-5/6">
                    <div class="surface-section px-4 py-5 md:px-6 lg:px-8">
                        <ul class="list-none p-0 m-0 flex align-items-center font-medium mb-3">
                            <li>
                                <a class="text-500 no-underline line-height-3 cursor-pointer">Tables</a>
                            </li>
                            <li class="px-2">
                                <i class="pi pi-angle-right text-500 line-height-3"></i>
                            </li>
                            <li>
                                <span class="text-900 line-height-3">
                                    <slot name="header"></slot>
                                </span>
                            </li>
                        </ul>
                        <div class="flex align-items-start flex-column lg:justify-content-between lg:flex-row">
                            <div>
                                <div class="font-medium text-3xl text-900">
                                    <slot name="header"></slot>
                                </div>
                                 <div class="flex align-items-center text-700 flex-wrap">
                                <div class="mr-5 flex align-items-center mt-3">
                                    <i class="pi pi-users mr-2"></i>
                                    <span>332 Active Users</span>
                                </div>
                                <div class="mr-5 flex align-items-center mt-3">
                                    <i class="pi pi-globe mr-2"></i>
                                    <span>9402 Sessions</span>
                                </div>
                                <div class="flex align-items-center mt-3">
                                    <i class="pi pi-clock mr-2"></i>
                                    <span>2.32m Avg. Duration</span>
                                </div>
                            </div> 
                            </div>
                        </div>
                    </div>

                     <Toolbar>
                <template #start>
                    <Button label="New" icon="pi pi-plus" class="mr-2" />
                    <Button label="Upload" icon="pi pi-upload" class="p-button-success" />
                    <i class="pi pi-bars p-toolbar-separator mr-2" />
                    <SplitButton label="Save" icon="pi pi-check" :model="items" class="p-button-warning"></SplitButton>
                </template>

                <template #end>
                    <Button icon="pi pi-search" class="mr-2" />
                    <Button icon="pi pi-calendar" class="p-button-success mr-2" />
                    <Button icon="pi pi-times" class="p-button-danger" />
                </template>
            </Toolbar> 
                    <div class="p-datatable-wrapper card">
                        <ConfirmDialog />
                        <slot name="table"></slot>
                    </div>
            </div>
        </div> -->
        <div class="p-datatable-wrapper card">
            <ConfirmDialog />
            <slot name="table"></slot>
        </div>
    </BasePageLayout>
</template>

<style lang="scss">
// body {
//     overflow-y: hidden;
// }

.p-datatable-wrapper {
    width: 100%;
}

.p-toolbar {
    padding: 0;
}

.p-toolbar * {
    margin: 0 0.2rem;
}

.p-header div * {
    margin: 0 0.2rem;
}

.p-form-input {
    width: 100%;
}

.p-dialog-titlebar-close {}

.p-datatable {
    // max-width: 1700px;
    margin: 0 auto;
    width: 100%;
}

::v-deep(.p-paginator) {
    .p-paginator-current {
        margin-left: auto;
    }
}

::v-deep(.p-progressbar) {
    height: .5rem;
    background-color: #D8DADC;

    .p-progressbar-value {
        background-color: #607D8B;
    }
}

::v-deep(.p-datepicker) {
    min-width: 25rem;

    td {
        font-weight: 400;
    }
}

::v-deep(.p-datatable.p-datatable-recipients) {
    .p-datatable-header {
        padding: 1rem;
        text-align: left;
        font-size: 1.5rem;
    }

    .p-paginator {
        padding: 1rem;
    }

    .p-datatable-thead>tr>th {
        text-align: left;
    }

    .p-datatable-tbody>tr>td {
        cursor: auto;
    }

    .p-dropdown-label:not(.p-placeholder) {
        text-transform: uppercase;
    }
}

.p-button.p-fileupload-choose {
    overflow: initial !important;
    cursor: pointer;
}

.p-datatable-tbody>tr>td {
    padding: 0.25rem 0.5rem !important;
}
</style>