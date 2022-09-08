<script setup>
import Button from 'primevue/button';
import Menu from 'primevue/menu';

import OverlayPanel from 'primevue/overlaypanel';
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
                // toast.add({ severity: 'success', summary: 'Updated', detail: 'Data Updated', life: 3000 });
                test();
            }
        },
        {
            label: 'Delete',
            icon: 'pi pi-times',
            command: () => {
                toast.add({ severity: 'warn', summary: 'Delete', detail: 'Data Deleted', life: 3000 });
            }
        }
        ]
    },
    {
        label: 'Navigate',
        items: [{
            label: 'Vue Website',
            icon: 'pi pi-external-link',
            url: 'https://vuejs.org/'
        },
        {
            label: 'Router',
            icon: 'pi pi-upload',
            command: () => {
                window.location.hash = "/fileupload"
            }
        }
        ]
    }
]);

const toggle = event => menu.value.toggle(event);
</script>

<template>
    <Button class="p-button-text p-button-sm p-button-secondary mb-2" label="More Options" @click="toggle"></Button>
    <Menu ref="menu" :model="items" :popup="true"></Menu>
    <!-- <OverlayPanel ref="menu" appendTo="body" :showCloseIcon="true">
        Hi
    </OverlayPanel> -->
</template>

<style lang="scss">
html .p-overlaypanel {
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
}

html .p-overlaypanel .p-overlaypanel-close {
    top: 0;
    right: 0;
    background: transparent;
    color: #5c5c5c;
}

html .p-overlaypanel .p-overlaypanel-close:enabled:hover {
    background: transparent;
    color: #7d7d7d;
}
</style>