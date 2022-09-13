<script setup>
import moment from 'moment';
defineProps(['status', 'lockIn', 'lockOut']);
</script>
<template>
    <div class="flex flex-col leading-tight tracking-tight">
        <span>
            <div v-if="status" class="flex flex-col space-y-2">
                <span>
                    <i class="pi pi-lock text-green-400"></i>
                    DB is locked
                </span>
                <span class="text-gray-600">
                    Database modifications will be delayed until app lock-out.
                </span>
                <span class="text-gray-600">
                    DB unlocks {{ moment.weekdaysShort()[lockOut.day] }} {{
                    lockOut.time }}
                </span>
            </div>
            <div v-else class="flex flex-col space-y-2">
                <span>
                    <i class="pi pi-lock-open text-blue-400"></i>
                    DB is unlocked
                </span>
                <span class="text-gray-600">
                    Database modifications will take effect.
                </span>
                <span class="">
                    DB locks {{ moment.weekdaysShort()[lockIn.day] }} {{
                    lockIn.time }}
                </span>
            </div>
        </span>
    </div>
</template>

<style lang="scss">
.badge {
    width: 1.5rem;
    height: 1.5rem;
    border-radius: 50%;
    background-color: var(--green-700);
}
</style>