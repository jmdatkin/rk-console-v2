<script setup>
import Calendar from "@/Components/Calendar";
import { ref } from 'vue';

defineProps(['limitSelect']);

const selectedDate = ref(null);
const dateChosen = ref(false);

const selectDateCallback = function (date) {
    selectedDate.value = date.start;
    dateChosen.value = true;
};

const openDateSelect = function() {
    dateChosen.value = false;
};

</script>
<template>
    <div v-if="!dateChosen">
        <Calendar :limitSelect="limitSelect" :onSelectCallback="selectDateCallback">
        </Calendar>
    </div>
    <div v-else>
        <slot :date="selectedDate" :openDateSelect="openDateSelect">

        </slot>
    </div>
</template>