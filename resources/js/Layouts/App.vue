<script setup>
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import { useToast } from 'primevue/usetoast';
import { inject, onBeforeUnmount } from 'vue';

const toast = useToast();
const toastBus = inject('toastBus');
toastBus.on('*', (type, args) => {
    switch (type) {
        case 'add':
            toast.add(args);
            break;
    }
});

onBeforeUnmount(() => {
    toastBus.all.clear();
});
</script>
<template>
    <Toast></Toast>
    <ConfirmDialog />
    <slot>

    </slot>
</template>