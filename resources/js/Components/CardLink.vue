<script setup>
import Card from 'primevue/card';
import { Link } from '@inertiajs/inertia-vue3'; 

</script>

<template>
    <Link class="p-card-link">
    <Card>
        <template #title>
            <slot name="title"></slot>
        </template>
        <template #content>
            <slot name="content"></slot>
        </template>
    </Card>
    </Link>
</template>

<style scoped lang="scss">
.p-card-link {
    flex-grow: 1;
    align-items: stretch;
    margin: 1rem;
}

.p-card-link div.p-card:hover {
    background-color: var(--surface-100);
}

.p-card-link div.p-card:hover {
    background-color: var(--surface-100);
}
</style>