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

        <div class="p-4 rounded-md border mb-2" v-for="job in pending_jobs">
            <PendingJobListItem :job="job">
            </PendingJobListItem>
        </div>

    </BasePageLayout>
</template>