<script setup>
import AssignmentLayout from '@/Layouts/AssignmentLayout';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import WeekView from '@/Components/WeekView';
import Weekday from '@/Components/Weekday';
import OverlayPanel from 'primevue/overlaypanel';

import { ref } from 'vue';

let weekdaySelect = function (day) {
    console.log(day);
};

const props = defineProps(['recipient_id']);

const recipientData = ref(null);
const dataLoaded = ref(false);

const sunOverlay = ref();
const sunToggle = (e) => sunOverlay.value.toggle(e);
const monOverlay = ref();
const monToggle = (e) => monOverlay.value.toggle(e);
const tuesOverlay = ref();
const tuesToggle = (e) => tuesOverlay.value.toggle(e);
const wedOverlay = ref();
const wedToggle = (e) => wedOverlay.value.toggle(e);
const thursOverlay = ref();
const thursToggle = (e) => thursOverlay.value.toggle(e);
const friOverlay = ref();
const friToggle = (e) => friOverlay.value.toggle(e);
const satOverlay = ref();
const satToggle = (e) => satOverlay.value.toggle(e);


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
                    <template #overlay>
                        Hi!
                    </template>
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