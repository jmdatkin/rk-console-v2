<script setup>
import DriverException from './DriverException';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import { computed } from 'vue';

const props = defineProps(['selectedDriver', 'onExceptionSelect']);
const exceptions = computed(() => {
    return props.selectedDriver.driver.exceptions;
});

</script>

<template>
    <Accordion :activeIndex="0">
        <AccordionTab v-for="exception in exceptions">
            <template #header>
                <div class="flex justify-between">
                    <!-- <span>{{ exception.driver.person.firstName }} {{ exception.driver.person.lastName }}</span> -->
                    <span>{{ exception.notes }}</span>
                </div>
            </template>
            <DriverException :row="props.selectedDriver" :onSelect="onExceptionSelect" :exception="exception"></DriverException>
        </AccordionTab>
    </Accordion>
</template>