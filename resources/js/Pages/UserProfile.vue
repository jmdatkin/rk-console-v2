<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Divider from 'primevue/divider';
import Card from 'primevue/card';

defineProps(['data']);
</script>

<template>
    <BasePageLayout>
        <template #header>
            Profile
        </template>
        <Card>
            <template #content>
                {{ data.person.firstName }} {{ data.person.lastName }}
            </template>
        </Card>
    </BasePageLayout>
</template>