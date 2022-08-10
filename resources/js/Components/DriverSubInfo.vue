<script setup>
import InfoItem from './InfoItem.vue';
import DriverDropdown from './DriverDropdown.vue';

defineProps(['data']);

const a = b => console.log(b);
</script>

<template>
    <h2>{{ data.route_name }}</h2>
    <h4>{{ data.date }}</h4>

    <div class="space-y-2">
        <InfoItem title="Driver">
            <!-- {{ data.firstName }} {{ data.lastName }} -->
            <DriverDropdown :initialValue="data.driver_id"></DriverDropdown>
        </InfoItem>

        <InfoItem title="Substitute Driver">
            <DriverDropdown :initialValue="data.sub_driver_id"></DriverDropdown>
        </InfoItem>
    </div>
</template>