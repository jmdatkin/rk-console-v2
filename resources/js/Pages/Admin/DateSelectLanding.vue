<script setup>
import { Inertia } from '@inertiajs/inertia';
import Calendar from '@/Components/Calendar';
import ReportLayoutVue from '../../Layouts/ReportLayout.vue';
import { DateAdapter } from '../../util';

const props = defineProps(['redirect_route']);

const redirect = function(date) {
    Inertia.visit(`${route(props.redirect_route)}/${DateAdapter.formatUrl(date)}`);
};

const onSelect = function(event) {
    redirect(event.start);
}
</script>

<template>
<ReportLayoutVue>
    <template #report>
    <Calendar :onSelectCallback="onSelect"></Calendar>


    </template>
</ReportLayoutVue>
</template>