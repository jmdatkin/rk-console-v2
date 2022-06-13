<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import Divider from 'primevue/divider';

const props = defineProps(['data', 'drivers', 'recipients']);
</script>
<template>
    <SingleResourceLayout>
        <span class="personnel-type">
            <i class="pi pi-fw pi-map"></i>
            Route
        </span>
        <div class="grid">
            <div class=col-12>
                <h2>{{ data.name }}</h2>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <span>Driver</span>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <span>Recipient</span>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <span>Notes</span>
                <h4>{{ data.notes }}</h4>
            </div>
        </div>
    </SingleResourceLayout>
</template>

<style lang="scss" scoped>
span {
    font-size: 12pt;
    font-weight: 600;
    text-transform: uppercase;
}
</style>