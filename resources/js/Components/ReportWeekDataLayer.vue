<script setup>
import moment from 'moment';
import { computed, onMounted, reactive, ref } from 'vue';
import ReportWeekView from './ReportWeekView.vue';
import Divider from 'primevue/divider';
import { DateAdapter } from '../util';

const props = defineProps(['date', 'openDateSelect', 'reportComponent', 'getDataFunction', 'requestURL']);

const weekdays = computed(() => {
    return moment.weekdays().map(day => moment(props.date).clone().day(day));
});

const subheader = computed(() => {
    // return `Week of ${moment(props.date).startOf('week').format("MMM DD YYYY")} through ${moment(props.date).endOf('week').format("MMM DD YYYY")}`;
    return `${moment(props.date).startOf('week').format("MMM DD YYYY")} - ${moment(props.date).endOf('week').format("MMM DD YYYY")}`;
});

const activeIndex = ref(moment(props.date).day());

const data = reactive({
    0: [],
    1: [],
    2: [],
    3: [],
    4: [],
    5: [],
    6: []
});
const dataLoaded = ref(false);

const getData = function () {
    dataLoaded.value = false;
    weekdays.value.forEach((val, idx) => {
        axios.get(`${props.requestURL}?date=${DateAdapter.make(val)}`)
            .then(res => data[idx] = res.data);
    });
    dataLoaded.value = true;
};

const dayChangeHandler = () => {};//e => activeIndex.value = e.index;

onMounted(() => {
    getData();
});

</script>

<template>
    <div class="grid">
        <div class="col-12 md:col-4">
            <Button class="p-button-text" icon="pi pi-chevron-left" label="Select Week"
                @click="openDateSelect"></Button>
        </div>
        <div class="col-12 md:col-4">
            <h4 class="text-center font-small text-gray-700 font-semibold align-middle">{{ subheader }}</h4>
        </div>
        <div class="col md:col-4">
        </div>
    </div>
    <div v-if="dataLoaded">
        <ReportWeekView v-model:activeIndex="activeIndex" @tab-change="dayChangeHandler"></ReportWeekView>
        <component :is="reportComponent" :data="data[activeIndex]" :date="weekdays[activeIndex]"></component>
    </div>
</template>

<style lang="scss" scoped>
h4 {}
</style>