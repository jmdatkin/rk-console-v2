<script setup>
import AssignmentLayout from '@/Layouts/AssignmentLayout';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import WeekView from '@/Components/WeekView';
import Weekday from '@/Components/Weekday';

import { ref } from 'vue';

let weekdaySelect = function (day) {
    console.log(day);
};

const props = defineProps(['recipient_id']);

const recipientData = ref(null);
const dataLoaded = ref(false);

axios.get(`/recipient/${props.recipient_id}`)
.then(res => {
    recipientData.value = res.data;
    dataLoaded.value = true;
}).catch(err => {
    console.error(err);
});
</script>


<template>
    <AssignmentLayout>
        <template #header>
            <span v-if="dataLoaded">
            {{ recipientData.person.firstName }} {{ recipientData.person.lastName }}
            </span>
        </template>
        <template #body>
            <!-- <TabView :activeIndex="activeIndex">
                <TabPanel header="Header I">
                    Content I
                </TabPanel>
                <TabPanel header="Header II">
                    Content II
                </TabPanel>
                <TabPanel header="Header III">
                    Content III
                </TabPanel>
            </TabView> -->
            <WeekView @weekdaySelect="weekdaySelect">
                <Weekday>
                    <template #head>
                        Sunday
                    </template>
                </Weekday>
                <Weekday>
                    <template #head>
                        Monday
                    </template>

                </Weekday>
                <Weekday>
                    <template #head>
                        Tuesday
                    </template>

                </Weekday>
                <Weekday>
                    <template #head>
                        Wednesday
                    </template>

                </Weekday>
                <Weekday>
                    <template #head>
                        Thursday
                    </template>

                </Weekday>
                <Weekday>
                    <template #head>
                        Friday
                    </template>

                </Weekday>
                <Weekday>
                    <template #head>
                        Saturday
                    </template>

                </Weekday>
            </WeekView>

        </template>
    </AssignmentLayout>
</template>

<style scoped lang="scss">
</style>