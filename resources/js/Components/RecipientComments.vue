<script setup>
import Textarea from 'primevue/textarea';
import Button from './Button';
import Comments from './Comments';
import { ref, reactive, onUpdated } from 'vue';
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

onUpdated(() => getData());

</script>

<template>
    <div class="flex flex-col">
        <Comments :comments="data">
        </Comments>
        <Textarea v-model="value"></Textarea>
        <Button @click="submitForm">Submit</Button>
    </div>
</template>