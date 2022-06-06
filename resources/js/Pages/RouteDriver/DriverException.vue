<script setup>
import Card from 'primevue/card';

defineProps(['data']);
</script>
<template>
    <Card class="mb-2">
        <template #title>
            {{ data.driver.person.firstName }} {{ data.driver.person.lastName }}
        </template>
        <template #content>
            <div class="flex flex-col">
                <span>
                From: {{ data.date_start }}
                </span>
                <span>
                To: {{ data.date_end }}
                </span>
                <span>
                Notes: {{ data.notes }}
                </span>
            </div>
        </template>
    </Card>
</template>