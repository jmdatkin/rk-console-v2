<script setup>
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import { inject, onBeforeUnmount } from 'vue';

const toast = useToast();
const toastBus = inject('toastBus');
toastBus.on('*', (type, args) => {
    console.log("Adding toast from event bus");
    switch (type) {
        case 'add':
            toast.add(args);
            break;
    }
});

onBeforeUnmount(() => {
    // toastBus.off("*");
    toastBus.all.clear();
});
</script>
<template>
        <Toast></Toast>
        <slot>

        </slot>
</template>