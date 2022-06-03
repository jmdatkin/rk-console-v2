<script setup>
import { ref } from 'vue';
import BasePageLayout from './BasePageLayout';
</script>

<template>
    <BasePageLayout>
        <template #header>
            <slot name="header"></slot>
        </template>
        <slot></slot>
        <div class="report-wrapper card">
            <slot name="report"></slot>
        </div>
    </BasePageLayout>
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