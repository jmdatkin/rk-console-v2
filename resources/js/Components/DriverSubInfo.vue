<script setup>
import InfoItem from './InfoItem.vue';
import DriverDropdown from './DriverDropdown.vue';
import DriverSubService from '@/Service/DriverSubService';
import AssignmentService from '@/Service/AssignmentService';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useConfirm } from 'primevue/useconfirm';
import moment from 'moment';

const props = defineProps(['data', 'date']);

const driver = ref();
const subDriver = ref();
if (props.data.drivers[0])
    driver.value = props.data.drivers[0].id;
if (props.data.substitute_drivers[0])
    subDriver.value = props.data.substitute_drivers[0].id;

const confirm = useConfirm();
const driverChanged = ref(false);
const subDriverChanged = ref(false);

const onDriverChange = function () {
    driverChanged.value = true;
}

const onSubDriverChange = function () {
    subDriverChanged.value = true;
}

const save = function () {
    let weekday = moment(props.date, 'MM-DD-YYYY').day();
    confirm.require({
        message: `Are you sure you want to assign this driver?`,//to route '${routeId}?`,
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-info',
        accept: () => {
            let dateForURL = moment(props.date, 'MM-DD-YYYY').toISOString();

            if (driverChanged.value) {
               AssignmentService.modifyDriverAssignment(driver.value, props.data.id, weekday) 
                    .then(
                        () => {
                            Inertia.reload();
                        },
                        () => {

                        }
                    )
            }


            if (subDriverChanged.value) {
                DriverSubService.createSub(driver.value, props.data.id, subDriver.value, dateForURL)
                    .then(
                        () => {
                            Inertia.reload();
                        },
                        () => {

                        }
                    )
            }
        },
    })
};

</script>

<template>
    <h2>{{ data.name }}</h2>
    <h4>{{ data.date }}</h4>

    <div class="space-y-2">
        <InfoItem title="Driver">
            <DriverDropdown class="w-full" v-model="driver" @change="onDriverChange"></DriverDropdown>
        </InfoItem>

        <InfoItem title="Substitute Driver">
            <DriverDropdown class="w-full" v-model="subDriver" @change="onSubDriverChange"></DriverDropdown>
        </InfoItem>
        <Button :disabled="!(driverChanged || subDriverChanged)" label="Save" @click="save"></Button>
    </div>
</template>