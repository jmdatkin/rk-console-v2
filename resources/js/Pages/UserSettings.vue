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
    axios.post(route('settings.user.save'), settings.value);
};

axios.get(route('settings.user')).then(res => {
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
            Admin Settings
        </template>
        <h3>Panel</h3>
        <div class="flex flex-col space-y-2">
            <InfoItem title="EEE">
                <InputSwitch v-model="settings.E"></InputSwitch>
            </InfoItem>
            <Button @click="saveSettings" label="Save"></Button>

        </div>
    </BasePageLayout>
</template>