<script setup>
import InfoItem from './InfoItem.vue';
import DriverDropdown from './DriverDropdown.vue';
import DriverSubService from '@/Service/DriverSubService';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import moment from 'moment';

const props = defineProps(['data', 'date']);

// const driver = ref(props.data.drivers[0].id ?? null);
// const subDriver = ref(props.data.substitute_drivers[0].id ?? null);
const driver = ref();
const subDriver = ref();
if (props.data.drivers[0])
    driver.value = props.data.drivers[0].id;
if (props.data.substitute_drivers[0])
    subDriver.value = props.data.substitute_drivers[0].id;

const driverChanged = ref(false);
const subDriverChanged = ref(false);

const onDriverChange = function() {
    driverChanged.value = true;
}

const onSubDriverChange = function() {
    subDriverChanged.value = true;
}

const save = function() {
    let dateForURL = moment(props.date).toISOString();
    if (subDriverChanged) {
       DriverSubService.createSub(driver.value, props.data.id, subDriver.value, dateForURL)
       .then(
        () => {
            Inertia.reload();
        },
        () => {

        }
       ) 
    }
    
}

</script>

<template>
    <h2>{{ data.name }}</h2>
    <h4>{{ data.date }}</h4>

    <div class="space-y-2">
        <InfoItem title="Driver">
            <!-- {{ data.firstName }} {{ data.lastName }} -->
            <DriverDropdown v-model="driver" @change="onDriverChange"></DriverDropdown>
        </InfoItem>

        <InfoItem title="Substitute Driver">
            <DriverDropdown v-model="subDriver" @change="onSubDriverChange"></DriverDropdown>
        </InfoItem>
        <Button :disabled="!(driverChanged || subDriverChanged)" label="Save" @click="save"></Button>
    </div>
</template>