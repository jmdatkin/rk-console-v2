<script setup>
import Setting from '../Components/Setting.vue';
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Calendar from 'primevue/calendar';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import BasePageLayout from '../Layouts/BasePageLayout.vue';
import InfoItem from '../Components/InfoItem.vue';
import TimezoneDropdown from '../Components/TimezoneDropdown.vue';
import WeekdayButton from '../Components/WeekdayButton.vue';
import TimeInput from '../Components/TimeInput.vue';
import moment from 'moment';

const settings = ref([]);

const mutators = {
    // 'lock_in_time': value => moment(value).tz('Etc/UTC'),
    // 'lock_out_time': value => moment(value).tz('Etc/UTC'),

    'lock_in_day': value => value.code,
    'lock_out_day': value => value.code,
};


const initSettings = function (data) {
    settings.value = data;
}

const saveSettings = function () {
    let data = settings.value;
    // let data = Object.entries(settings.value)
    // .map(([key,value]) => {
    //     return {
    //         key,
    //         value: mutators[key] ? mutators[key](value) : value
    //     };
    // })
    // .reduce((obj, item) => {
    //     return Object.assign(obj, {[item.key]: item.value})
    // }, {});
    console.log(data);
    axios.post(route('settings.save'), data);
};

const onTimeChange = key => function (time) {
    settings.value[key] = time;
};

const makeOnChange = (keyName) => {
    return function (evt) {
        settings.value[keyName] = evt.target.value;
    };
};

onMounted(() => {
    axios.get(route('settings.data')).then(res => {
        console.log(res.data);
        let d = {};
        res.data.forEach(data => {
            d[data.key] = data.value;
        });
        console.log(d);
        initSettings(d);
    });
})
</script>
<template>
    <BasePageLayout>
        <template #header>
            Application Settings
        </template>
        <div class="px-4 md:px-0">
            <!-- <h3>Panel</h3> -->
            <div class="flex flex-col space-y-2">
                <!-- <InfoItem title="Timezone">
                <TimezoneDropdown v-model="settings.timezone"></TimezoneDropdown>
            </InfoItem> -->
                <div class="mb-4 space-y-4">
                    <InfoItem title="Lock-In">
                        <div class="flex space-x-2">
                            <WeekdayButton v-model="settings.lock_in_day"></WeekdayButton>
                            <TimeInput v-model="settings.lock_in_time"></TimeInput>
                        </div>
                    </InfoItem>
                    <InfoItem title="Lock-Out">
                        <div class="flex space-x-2">
                            <WeekdayButton v-model="settings.lock_out_day"></WeekdayButton>
                            <TimeInput v-model="settings.lock_out_time"></TimeInput>
                        </div>
                    </InfoItem>
                </div>
                <!-- <InputText v-model="settings.x"></InputText> -->
                <Button class="w-[6rem]" @click="saveSettings" label="Save"></Button>


            </div>

        </div>
    </BasePageLayout>
</template>