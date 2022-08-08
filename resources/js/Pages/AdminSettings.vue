<script setup>
import Setting from '../Components/Setting.vue';
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import Calendar from 'primevue/calendar';
import { ref } from 'vue';
import axios from 'axios';
import BasePageLayout from '../Layouts/BasePageLayout.vue';
import InfoItem from '../Components/InfoItem.vue';
import TimezoneDropdown from '../Components/TimezoneDropdown.vue';

const settings = ref([]);

const initSettings = function (data) {
    settings.value = data;
}

const saveSettings = function () {
    // axios.post(route('settings.save', settings.value));
    axios.post(route('settings.save'), settings.value);
};

axios.get(route('settings.data')).then(res => {
    console.log(res.data);
    let d = {};
    res.data.forEach(data => {
        d[data.key] = data.value;
    });
    console.log(d);
    initSettings(d);
});
</script>
<template>
    <BasePageLayout>
        <template #header>
            Application Settings
        </template>
        <!-- <h3>Panel</h3> -->
        <div class="flex flex-col space-y-2">
            <InfoItem title="Timezone">
                <TimezoneDropdown v-model="settings.timezone"></TimezoneDropdown>
                <!-- <InputSwitch v-model="settings.test"></InputSwitch> -->
            </InfoItem>
            <InfoItem title="Lock-In Time">
                <Calendar v-model="settings.lock_in_time" :showTime="true"  hourFormat="12" :stepMinute="15" dateFormat="D" />
            </InfoItem>
            <InfoItem title="Lock-Out Time">
                <Calendar v-model="settings.lock_out_time" :showTime="true"  hourFormat="12" :stepMinute="15" dateFormat="D" />
            </InfoItem>
                <!-- <InputText v-model="settings.x"></InputText> -->
            <Button @click="saveSettings" label="Save"></Button>

        </div>
    </BasePageLayout>
</template>