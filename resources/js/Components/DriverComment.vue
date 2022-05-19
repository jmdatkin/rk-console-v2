<script setup>
import Panel from 'primevue/panel';
import Divider from 'primevue/divider';
import Avatar from 'primevue/avatar';
import Tooltip from 'primevue/tooltip'
import { computed } from 'vue';

const props = defineProps(['comment']);

const vTooltip = Tooltip;

const driverNameAbbr = computed(() => {
    return props.comment.driver.person.firstName.substring(0, 1).toUpperCase();
});

const driverName = computed(() => {
    return `${props.comment.driver.person.firstName} ${props.comment.driver.person.lastName}`;
});

</script>

<template>
    <div class="flex flex-col align-start">
        <div class="flex flex-row align-start">
            <Avatar class="mr-2" icon="pi pi-search" shape="circle" :label="driverNameAbbr" v-tooltip.left="driverName" />
            <!-- <div> -->
                <!-- <strong>{{ driverName }}</strong> -->
                <div>
                    {{ comment.body }}
                </div>
            <!-- </div> -->
        </div>
        <Divider />
    </div>
</template>