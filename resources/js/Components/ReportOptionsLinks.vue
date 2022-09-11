<script setup>
import Button from 'primevue/button';
import Menu from 'primevue/menu';
import { ref } from 'vue';

const test = function() {
    document.querySelector('.p-fileupload input[type="file"]').click();
};

const menu = ref();
const items = ref([
    {
        label: 'Options',
        items: [{
            label: 'Import from CSV',
            icon: 'pi pi-file',
            command: () => {
                // test();
            }
        },
        ]
    },
]);

const toggle = event => menu.value.toggle(event);
</script>

<template>
    <Button class="p-button-text p-button-sm p-button-secondary mb-2" label="More Options" @click="toggle"></Button>
    <Menu ref="menu" :model="items" :popup="true"></Menu>
</template>

<style lang="scss">
</style>