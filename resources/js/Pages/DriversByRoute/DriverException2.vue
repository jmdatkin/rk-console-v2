<script setup>
import Card from 'primevue/card';
import Button from 'primevue/button';
import InfoItem from '@/Components/InfoItem';
import Divider from 'primevue/divider';

const props = defineProps(['exception', 'driver', 'onSelect']);



</script>
<template>
    <!-- <Card class="mb-2"> -->
    <!-- <template #title>
            {{ data.driver.person.firstName }} {{ data.driver.person.lastName }}
        </template> -->
    <!-- <template #content> -->
    <div class="p-driver-exception flex flex-col">
        {{ driver.driver.person.firstName }} {{ driver.driver.person.lastName }}
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
        <Button @click="() => onSelect({ routeId: driver.routeId, ...exception})">Assign Substitute</Button>
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