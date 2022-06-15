<script setup>
import Card from 'primevue/card';
import Button from 'primevue/button';
import InfoItem from '@/Components/InfoItem';
import Divider from 'primevue/divider';

const props = defineProps(['data', 'onSelect']);



</script>
<template>
    <!-- <Card class="mb-2"> -->
    <!-- <template #title>
            {{ data.driver.person.firstName }} {{ data.driver.person.lastName }}
        </template> -->
    <!-- <template #content> -->
    <div class="p-driver-exception flex flex-col">
        {{ data.driver.person.firstName }} {{ data.driver.person.lastName }}
        <div class="flex flex-row">
            <InfoItem title="From" class="mr-6">
                {{ data.date_start }}
            </InfoItem>
            <InfoItem title="To">
                {{ data.date_end }}
            </InfoItem>
        </div>
        <InfoItem icon="pi pi-file" title="Notes">
            {{ data.notes }}
        </InfoItem>
        <Button @click="() => onSelect(props.data)">Assign Substitute</Button>
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