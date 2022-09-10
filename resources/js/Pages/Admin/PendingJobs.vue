<script setup>
import BasePageLayout from '../../Layouts/BasePageLayout.vue';
import PendingJobListItem from '../../Components/PendingJobListItem.vue';
import Card from 'primevue/card';

defineProps(['pending_jobs']);

</script>

<template>
    <BasePageLayout>
        <template #header>
            Pending Jobs
        </template>

        <div class="space-y-2">
        <PendingJobListItem v-for="job in pending_jobs" :job="job">
        </PendingJobListItem>

        </div>

    </BasePageLayout>
</template>