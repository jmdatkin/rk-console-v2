<script setup>
import BasePageLayout from '../../Layouts/BasePageLayout.vue';
import PendingJobListItem from '../../Components/PendingJobListItem.vue';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import InputText from 'primevue/inputtext';
import Card from 'primevue/card';
import { computed, ref } from 'vue';
import PendingJobHeaderInfo from '../../Components/PendingJobHeaderInfo.vue';
import PendingJobPayloadTable from '../../Components/PendingJobPayloadTable.vue';

const props = defineProps(['pending_jobs']);

const filter = ref('');

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
        <InputText v-model="filter"></InputText>
        <div class="space-y-2">
            <!-- <PendingJobListItem v-for="job in pending_jobs" :job="job"> -->
            <!-- <PendingJobListItem v-for="job in filteredJobs" :job="job">
        </PendingJobListItem> -->
            <Accordion :multiple="true" lazy>
                <AccordionTab v-for="job in filteredJobs">
                    <template #header>
                        <PendingJobHeaderInfo :job="job"></PendingJobHeaderInfo>
                    </template>
                <PendingJobPayloadTable :job="job"></PendingJobPayloadTable>
                </AccordionTab>
            </Accordion>

        </div>

    </BasePageLayout>
</template>