<script setup>
import Setting from '../Components/Setting.vue';
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import { ref } from 'vue';
import axios from 'axios';

const settings = ref({
    test: false,
    x: '',
});

const initSettings = function (data) {
    settings.value = data;
}

const saveSettings = function () {
    // axios.post(route('settings.save', settings.value));
    axios.post(route('settings.save'), settings.value);
};

axios.get(route('settings')).then(res => {
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
    <InputSwitch v-model="settings.test"></InputSwitch>
    <InputText v-model="settings.x"></InputText>
    <Button @click="saveSettings" label="Save"></Button>
</template>