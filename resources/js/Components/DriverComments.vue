<script setup>
import Textarea from 'primevue/textarea';
import DriverComment from './DriverComment';
import Button from './Button';
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['recipientId', 'driverId']);

const value = ref('');

const data = ref([]);
const getData = function () {
    axios.get('/comment/recipient/' + props.recipientId)
        .then(res => {
            data.value = res.data;
        })
};

const submitForm = function () {
    Inertia.post('/comment/store', {
        body: value.value,
        driver_id: props.driverId,
        recipient_id: props.recipientId
    },
        {
            onFinish: () => {
                getData();
            }
        }
    );
};

getData();

</script>

<template>
    <div class="">
        <DriverComment v-for="comment in data" :comment="comment"></DriverComment>
        <!-- <form @submit.prevent="submitForm"> -->
        <Textarea v-model="value"></Textarea>
        <Button @click="submitForm">Submit</Button>
        <!-- </form> -->

    </div>
</template>