<script setup>
import { computed } from 'vue';
import InfoItem from './InfoItem.vue';
const props = defineProps(['data']);
const fullName = computed(() => `${props.data.firstName} ${props.data.lastName}`);
</script>

<template>
    <div>
        <span class="personnel-type">
            <i class="pi pi-fw pi-user"></i>
            Personnel
        </span>
        <div class="grid">
            <div class=col-12>
                <h2>{{ fullName }}</h2>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Email">
                    {{ data.email }}
                </InfoItem>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Home Phone">
                    {{ data.phoneHome }}
                </InfoItem>
                <InfoItem title="Cell Phone">
                    {{ data.phoneCell }}
                </InfoItem>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
                <InfoItem title="Notes">
                    {{ data.notes }}
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