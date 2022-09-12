<script setup>
import BasePageLayout from '../../Layouts/BasePageLayout.vue';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import { computed, ref } from 'vue';
import PendingJobHeaderInfo from '../../Components/PendingJobHeaderInfo.vue';
import PendingJobPayloadTable from '../../Components/PendingJobPayloadTable.vue';

const props = defineProps(['pending_jobs']);

const filter = ref('');

const selected = ref([]);

const filteredJobs = computed(() => {
    if (filter.value === '') return props.pending_jobs;
    return props.pending_jobs.filter(job => {
        return job.payload[0] == filter.value;
    });
});
</script>

<template>
    <BasePageLayout>
        <template #header>
            Pending Jobs
        </template>
        <div class="space-y-2">
            <Accordion :multiple="true" lazy>
                <AccordionTab v-for="job in filteredJobs">
                    <template #header>
                        <PendingJobHeaderInfo :job="job"></PendingJobHeaderInfo>
                    </template>
                    <div class="flex flex-col">
                        <span class="space-x-2">
                            <span class="font-semibold">Scheduled By</span>
                            <span>{{ job.user.firstName }} {{ job.user.lastName }}</span>
                        </span>
                        <PendingJobPayloadTable :job="job"></PendingJobPayloadTable>
                    </div>
                </AccordionTab>
            </Accordion>
        </div>
    </BasePageLayout>
</template>

<style lang="scss">
html .p-accordion .p-accordion-tab {
    margin-bottom: 0.5rem;
}
</style>