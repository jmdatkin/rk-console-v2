<script setup>
import Setting from '../Components/Setting.vue';
import InputText from 'primevue/inputtext';
import InputSwitch from 'primevue/inputswitch';
import { ref } from 'vue';
import axios from 'axios';

const settings = ref({
    test: false
});

const initSettings = function(data) {
    settings.value = data;
}

const saveSettings = function() {
    // axios.post(route('settings.save', settings.value));
    axios.post(route('settings.save'), settings.value);
};

axios.get(route('settings')).then(res => {
    console.log(res.data);
    initSettings(res.data)
    });
</script>
<template>
    <InputSwitch v-model="settings.test"></InputSwitch>
    <Button @click="saveSettings" label="Save"></Button>
</template>