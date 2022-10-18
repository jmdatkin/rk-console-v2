<script setup>
import Calendar from '@/Components/Calendar';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import BasePageLayout from '../../Layouts/BasePageLayout.vue';
import { ref } from 'vue';

const storePeriod = function(driver_id, date_start, date_end) {
    axios.post(route('substitute.period.store'), {
        driver_id, date_start, date_end
    });
};

const dialogOpen = ref(false);

const onSelect = function() {
    dialogOpen.value = true;
};
</script>

<template>
    <Dialog v-model:visible="dialogOpen">
        Hi
        <Button @click="storePeriod"></Button>
    </Dialog>
    <BasePageLayout>
        <Calendar :onSelectCallback="onSelect">

        </Calendar>
    </BasePageLayout>
</template>