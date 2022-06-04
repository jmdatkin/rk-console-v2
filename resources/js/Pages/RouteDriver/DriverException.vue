<script setup>
defineProps(['data']);
</script>
<template>
From: {{ data.date_start }}
To: {{ data.date_end }}
Notes: {{ data.notes }}
</template>