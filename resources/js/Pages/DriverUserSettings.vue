<script setup>
import InputSwitch from 'primevue/inputswitch';
import { ref } from 'vue';
import axios from 'axios';
import BasePageLayout from '../Layouts/BasePageLayout.vue';
import InfoItem from '../Components/InfoItem.vue';

const settings = ref([]);

const initSettings = function (data) {
    settings.value = data;
}

const saveSettings = function () {
    axios.post(route('settings.user.save'), settings.value);
};

axios.get(route('settings.user.data')).then(res => {
    let d = {};
    res.data.forEach(data => {
        d[data.key] = data.value;
    });
    initSettings(d);
});
</script>
<template>
    <BasePageLayout>
        <template #header>
            User Settings
        </template>
        <div class="flex flex-col space-y-2">
            <InfoItem title="Defer DB Actions by Default">
                <InputSwitch v-model="settings.E"></InputSwitch>
            </InfoItem>
            <Button @click="saveSettings" label="Save"></Button>

        </div>
    </BasePageLayout>
</template>