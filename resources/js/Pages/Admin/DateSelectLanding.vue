<script setup>
import { Inertia } from '@inertiajs/inertia';
import Calendar from '@/Components/Calendar';
import ReportLayoutVue from '../../Layouts/ReportLayout.vue';
import { DateAdapter } from '../../util';

const props = defineProps(['redirect_route', 'header']);

const redirect = function (date) {
    Inertia.visit(`${Inertia.page.url}/${DateAdapter.formatUrl(date)}`);
};

const onSelect = function (event) {
    redirect(event.start);
}
</script>

<template>
    <ReportLayoutVue>
        <template #header>
            {{ header }}
        </template>
        <template #report>
            <Calendar :onSelectCallback="onSelect"></Calendar>
        </template>
    </ReportLayoutVue>
</template>