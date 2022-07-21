<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import InfoItem from './InfoItem.vue';
import Button from 'primevue/button';
import Toolbar from 'primevue/toolbar';
import InputText from 'primevue/inputtext';
import RecipientService from '../Service/RecipientService';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['data']);
const fullName = computed(() => `${props.data.person.firstName} ${props.data.person.lastName}`);

const form = ref({
    email: props.data.person.email,
    phoneHome: props.data.person.phoneHome,
    phoneCell: props.data.person.phoneCell,
    numMeals: props.data.numMeals,
    address: props.data.address,
    notes: props.data.person.notes
    // email: '',
    // phoneHome: '',
    // phoneCell: '',
    // numMeals: ''
});

const editing = ref(false);

const submit = () => {
    editing.value = false;
    RecipientService.edit(props.data.id, form.value)
    .then(
        () => {
            Inertia.reload();
        }
    );
};
// onMounted(() => {
//     form.value = {
//         email: props.data.person.email
//     };
// });

// const editing = ref(false);

</script>

<template>
    <div>
        <!-- <span class="personnel-type">
            <i class="pi pi-fw pi-box"></i>
            Recipient
        </span> -->
        <Toolbar>
            <template #start>
        <InfoItem title="Recipient" icon="pi pi-fw pi-box"></InfoItem>
            </template>
            <template #end>

                <span v-if="editing">
                <Button icon="pi pi-check" class="p-button-rounded p-button-secondary p-button-text" @click="submit" />
                <Button icon="pi pi-times" class="p-button-rounded p-button-secondary p-button-text" @click="() => editing= false" />
                </span>
                <span v-else>
                <Button icon="pi pi-pencil" class="p-button-rounded p-button-secondary p-button-text" @click="() => editing= true" />
                </span>
            </template>
        </Toolbar>
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
                    <InputText v-if="editing" v-model="form.phoneHome">
                        {{ data.person.phoneHome }}
                    </InputText>
                    <span v-else>
                        {{ data.person.phoneHome }}
                    </span>
                </InfoItem>
                <InfoItem title="Cell Phone">
                    <InputText v-if="editing" v-model="form.phoneCell">
                        {{ data.person.phoneCell }}
                    </InputText>
                    <span v-else>
                        {{ data.person.phoneCell }}
                    </span>
                </InfoItem>
            </div>
        </div>
        <div class="grid mb-2">
            <div class=col-12>
                <InfoItem title="Num. Meals">
                    <InputText v-if="editing" v-model="form.numMeals">
                        {{ data.numMeals }}
                    </InputText>
                    <span v-else>
                        {{ data.numMeals }}
                    </span>
                </InfoItem>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Address">
                    <InputText v-if="editing" v-model="form.address">
                        {{ data.person.address }}
                    </InputText>
                    <span v-else>
                        {{ data.person.address }}
                    </span>
                </InfoItem>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Notes">
                    <InputText v-if="editing" v-model="form.notes">
                        {{ data.person.notes }}
                    </InputText>
                    <span v-else>
                        {{ data.person.notes }}
                    </span>
                </InfoItem>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
</style>