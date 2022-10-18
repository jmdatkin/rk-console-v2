<script setup>
import Divider from 'primevue/divider';

const props = defineProps(['data']);
</script>
<template>
    <div>
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
    </div>
</template>

<style lang="scss" scoped>
span {
    font-size: 12pt;
    font-weight: 600;
    text-transform: uppercase;
}
</style>