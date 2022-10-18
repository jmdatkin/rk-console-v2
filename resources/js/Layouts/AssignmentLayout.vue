<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
</script>

<template>
    <AuthenticatedLayout>
        <slot></slot>
        <div class="relative flex pt-0 justify-center min-h-screen bg-gray-100 sm:pt-2">
            <div class="flex flex-col px-0 w-full max-w-screen-2xl">
                <div class="surface-section px-4 py-5 md:px-6 lg:px-8">
                    <ul class="list-none p-0 m-0 flex align-items-center font-medium mb-3">
                        <li>
                            <a class="text-500 no-underline line-height-3 cursor-pointer">Reports</a>
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
                        </div>
                    </div>
                    <div class="report-wrapper flex card">
                        <slot name="body"></slot>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss">
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