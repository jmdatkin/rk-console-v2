<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Avatar from 'primevue/avatar';
import Divider from 'primevue/divider';
import Card from 'primevue/card';
import { ref, computed } from 'vue';

const props = defineProps(['data']);

const nameAbbr = computed(() => {
    return `${props.data.person.firstName.substring(0,1).toUpperCase()}${props.data.person.lastName.substring(0,1).toUpperCase()}`;
});

</script>

<template>
    <BasePageLayout>
        <template #header>
            Profile
        </template>
        <div class="grid">
            <div class="col-12 sm:col-4">
                <Card>
                    <template #content>
                        <Avatar :label="nameAbbr" size="large" />
                        {{ data.person.firstName }} {{ data.person.lastName }}
                    </template>
                </Card>
            </div>
            <div class="col-12 sm:col-6">
                <Card>
                    <template #content>
                        Home Phone:
                        {{ data.person.phoneHome }}
                    </template>
                </Card>

            </div>
        </div>
    </BasePageLayout>
</template>