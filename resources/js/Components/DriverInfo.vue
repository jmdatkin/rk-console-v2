<script setup>
import { computed } from 'vue';
import InfoItem from './InfoItem.vue';
const props = defineProps(['data']);
const fullName = computed(() => `${props.data.person.firstName} ${props.data.person.lastName}`);
</script>

<template>
    <div>
        <span class="personnel-type">
            <i class="pi pi-fw pi-car"></i>
            Driver
        </span>
        <div class="grid">
            <div class=col-12>
                <h2>{{ fullName }}</h2>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Email">
                    {{ data.person.email }}
                </InfoItem>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Home Phone">
                    {{ data.person.phoneHome }}
                </InfoItem>
                <InfoItem title="Cell Phone">
                    {{ data.person.phoneCell }}
                </InfoItem>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
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
span {
    font-size: 12pt;
    font-weight: 600;
    text-transform: uppercase;
}
</style>