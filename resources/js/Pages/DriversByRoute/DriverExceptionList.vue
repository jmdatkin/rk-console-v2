<script setup>
import DriverException from './DriverException';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';

const props = defineProps(['exceptions', 'onExceptionSelect']);
</script>

<template>


<Accordion>
    <AccordionTab v-for="exception in exceptions">
        <template #header>
            <div class="flex justify-between">
                <!-- <span>{{ exception.driver.person.firstName }} {{ exception.driver.person.lastName }}</span> -->
                <span>{{ exception.notes }}</span>
            </div>
        </template>
        <DriverException :onSelect="onExceptionSelect" :data="exception"></DriverException>
    </AccordionTab>
</Accordion>
<!-- <DriverException v-for="exception in exceptions" :onSelect="onExceptionSelect" :data="exception">
</DriverException> -->


</template>