<script setup>
import OutreachReportTable from './OutreachReportTable.vue';
import moment from 'moment';
import { computed, onMounted, reactive, ref } from 'vue';
import ReportWeekView from '../ReportWeekView.vue';
import { DateAdapter } from '../../util';

const props = defineProps(['date', 'openDateSelect']);

const weekdays = computed(() => {
    return moment.weekdays().map(day => moment(props.date).clone().day(day));
});

const subheader = computed(() => {
    return `Week of ${moment(props.date).startOf('week').format("MMM DD YYYY")} through ${moment(props.date).endOf('week').format("MMM DD YYYY")}`;
});

const selectedIdx = ref(moment(props.date).day());

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
        axios.get(route('report.outreach.data', { date: DateAdapter.make(val) }))
            .then(res => data[idx] = res.data);
    });
    dataLoaded.value = true;
};

const dayChangeHandler = function (e) {
    let { index } = e;
    selectedIdx.value = index;
};

onMounted(() => {
    getData();
});

</script>

<template>
    <Button class="p-button-text" icon="pi pi-chevron-left" label="Select Week" @click="openDateSelect"></Button>
    <h4 class="text-center">{{ subheader }}</h4>
    <div v-if="dataLoaded">
    <ReportWeekView @tab-change="dayChangeHandler"></ReportWeekView>
    <OutreachReportTable :data="data[selectedIdx]" :date="weekdays[selectedIdx]"></OutreachReportTable>
    </div>
</template>