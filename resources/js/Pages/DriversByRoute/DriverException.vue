<script setup>
import Card from 'primevue/card';
import Button from 'primevue/button';
import InfoItem from '@/Components/InfoItem';
import InputText from 'primevue/inputtext';
import Divider from 'primevue/divider';
import { computed } from 'vue';

const props = defineProps(['exception', 'row', 'onSelect']);

const hasSubstitute = computed(() => {
    return props.exception.substitutes.length > 0;
});

const substituteFullName = computed(() => {
    return hasSubstitute ?
    `${props.exception.substitutes[0].person.firstName} ${props.exception.substitutes[0].person.lastName}`
    : ''
});


</script>
<template>
    <!-- <Card class="mb-2"> -->
    <!-- <template #title>
            {{ data.driver.person.firstName }} {{ data.driver.person.lastName }}
        </template> -->
    <!-- <template #content> -->
    <div class="p-driver-exception flex flex-col">
        <!-- {{ row.driver.person.firstName }} {{ row.driver.person.lastName }} -->
        <div class="flex flex-row flex-wrap">
            <InfoItem title="From" class="mr-6">
                {{ exception.date_start }}
            </InfoItem>
            <InfoItem title="To">
                {{ exception.date_end }}
            </InfoItem>
        </div>
        <InfoItem icon="pi pi-file" title="Notes">
            {{ exception.notes }}
        </InfoItem>
        <Divider />
        <InfoItem icon="pi pi-car" title="Original Driver">
            {{ row.originalDriver.person.firstName }} {{ row.originalDriver.person.lastName }}
        </InfoItem>
        <InfoItem v-if="row.isSub" icon="pi pi-car" title="Substitute Driver">
            {{ row.substitute.person.firstName }} {{ row.substitute.person.lastName }}
        </InfoItem>
        <Button @click="() => onSelect({ routeId: row.routeId, ...exception})">Assign Substitute</Button>
        <!-- <span>
                    From: {{ data.date_start }}
                </span>
                <span>
                    To: {{ data.date_end }}
                </span>
                <span>
                    Notes: {{ data.notes }}
                </span> -->
    </div>
    <!-- </template> -->
    <!-- </Card> -->
</template>

<style lang="scss">
.p-driver-exception>* {
    margin: 0.75rem 0;
}
</style>