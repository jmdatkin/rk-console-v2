<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import InfoItem from './InfoItem.vue';
import InputText from 'primevue/inputtext';

const props = defineProps(['data', 'editing']);
const fullName = computed(() => `${props.data.person.firstName} ${props.data.person.lastName}`);

const form = ref({
    email: ''
});

onMounted(() => {
    form.value = {
        email: props.data.person.email
    };
});

// const editing = ref(false);

</script>

<template>
    <div>
        <!-- <span class="personnel-type">
            <i class="pi pi-fw pi-box"></i>
            Recipient
        </span> -->
        <InfoItem title="Recipient" icon="pi pi-fw pi-box"></InfoItem>
        <div class="grid">
            <div class=col-12>
                <h2>{{ fullName }}</h2>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Email">
                    <InputText v-if="editing" v-model="form.email">
                        {{ data.person.email }}
                    </InputText>
                    <span v-else>
                        {{ data.person.email }}
                    </span>
                </InfoItem>
                <!-- <span>Email</span>
                <h4>{{ data.person.email }}</h4> -->
            </div>
        </div>
        <Divider />
        <div class="grid mb-2">
            <div class=col-12>
                <InfoItem title="Home Phone">
                    {{ data.person.phoneHome }}
                </InfoItem>
                <InfoItem title="Cell Phone">
                    {{ data.person.phoneCell }}
                </InfoItem>
            </div>
        </div>
        <div class="grid mb-2">
            <div class=col-12>
                <InfoItem title="Num. Meals">
                    {{ data.numMeals }}
                </InfoItem>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Address">
                    {{ data.address }}
                </InfoItem>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Notes">
                    {{ data.person.notes }}
                </InfoItem>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
</style>