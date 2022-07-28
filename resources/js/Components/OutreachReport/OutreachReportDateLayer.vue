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

const selectedIdx = ref(0);

const data = reactive({
    0: [],
    1: [],
    2: [],
    3: [],
    4: [],
    5: [],
    6: []
});

const getData = function () {
    weekdays.value.forEach((val, idx) => {
        axios.get(route('report.outreach.data', { date: DateAdapter.make(val) }))
            .then(res => data[idx] = res.data);
    });
};

const dayChangeHandler = function (e) {
    let { index } = e;
    console.log(index);
    // thisDate.value = startOfWeek.value.clone().add(index, 'days');
    selectedIdx.value = index;
    // getData();
};

// const data = ref([]);

onMounted(() => {
    getData();
});

</script>

<template>
    <Button class="p-button-text" icon="pi pi-chevron-left" label="Select Week" @click="openDateSelect"></Button>
    <h4 class="text-center">{{ subheader }}</h4>
    <ReportWeekView @tab-change="dayChangeHandler"></ReportWeekView>
    <!-- <OutreachReportTable :date="thisDate" :openDateSelect="openDateSelect"></OutreachReportTable> -->
    <OutreachReportTable :data="data[selectedIdx]" :date="weekdays[selectedIdx]"></OutreachReportTable>
</template>