<script setup>
import BasePageLayout from '@/Layouts/BasePageLayout';
import Avatar from 'primevue/avatar';
import Panel from 'primevue/panel';
import { ref, computed } from 'vue';
import InfoItem from '../Components/InfoItem.vue';

const props = defineProps(['data']);

const nameAbbr = computed(() => {
    return `${props.data.person.firstName.substring(0, 1).toUpperCase()}${props.data.person.lastName.substring(0, 1).toUpperCase()}`;
});

</script>

<template>
    <BasePageLayout>
        <template #header>
            Profile
        </template>
        <div class="grid">
            <div class="col-12 md:col-4">
                <Panel header="Account Information">
                    <div class="py-2 mb-2">
                        <Avatar :label="nameAbbr" size="large" />
                        {{ data.person.firstName }} {{ data.person.lastName }}
                    </div>

                    <InfoItem title="Email" class="mb-2">
                        {{ data.person.email }}
                    </InfoItem>
                    <InfoItem title="Home Phone" class="mb-2">
                        {{ data.person.phoneHome }}
                    </InfoItem>
                    <InfoItem title="Cell Phone" class="mb-2">
                        {{ data.person.phoneHome }}
                    </InfoItem>
                </Panel>
            </div>
            <div class="col-12 md:col-6">
                <Panel>
                    <h6>Account Management</h6>
                    <ul class="list-disc list-outside pl-4">
                        <li><a>Change Password</a></li>
                    </ul>
                </Panel>

            </div>
        </div>
    </BasePageLayout>
</template>