<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated';
import Calendar from "@/Components/Calendar";
import { ref } from 'vue';

const selectedDate = ref(null);
const dateChosen = ref(false);

const selectDateCallback = function (date) {
    selectedDate.value = date.start;
    dateChosen.value = true;
};

const openDateSelect = function() {
    dateChosen.value = false;
}

</script>

<template>
<AuthenticatedLayout>
    <div v-if="!dateChosen">
        <Calendar :onSelectCallback="selectDateCallback">
        </Calendar>
    </div>
    <div v-else>
        <slot name="content" :date="selectedDate" :openDateSelect="openDateSelect">

        </slot>
    </div>
</AuthenticatedLayout>
</template>