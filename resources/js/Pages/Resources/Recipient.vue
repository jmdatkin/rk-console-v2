<script setup>
import SingleResourceLayout from '@/Layouts/SingleResourceLayout';
import Divider from 'primevue/divider';
import Card from 'primevue/card';
import RecipientInfo from './Recipients/RecipientInfo';

const props = defineProps(['data']);


</script>

<template>
    <SingleResourceLayout>
        <Card class="mt-4">
            <template #content>
                <RecipientInfo :data="data"></RecipientInfo>
            </template>
        </Card>
    </SingleResourceLayout>
</template>