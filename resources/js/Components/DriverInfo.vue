<script setup>
import { computed } from 'vue';
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
                <span>Email</span>
                <h4>{{ data.person.email }}</h4>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <span>Home Phone</span>
                <h4>{{ data.person.phoneHome }}</h4>
                <span>Cell Phone</span>
                <h4>{{ data.person.phoneCell }}</h4>
            </div>
        </div>
        <div class="grid">
            <div class=col-12>
            </div>
        </div>
        <Divider />
        <div class="grid">
            <div class=col-12>
                <span>Notes</span>
                <h4>{{ data.person.notes }}</h4>
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