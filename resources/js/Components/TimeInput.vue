<script setup>
import InputMask from 'primevue/inputmask';

const onBlur = function(event) {
    let value = event.target.value;

    let [hour, minute] = value.split(':');

    hour = Number(hour);
    minute = Number(minute);

    if (hour < 0    || hour > 24    ||
        minute < 0  || minute > 60)
        event.target.classList.add('p-invalid');
    else
        event.target.classList.remove('p-invalid');
}

</script>

<template>
<InputMask class="w-[3.75rem]" @blur="onBlur" mask="99:99" maxlength="5"></InputMask>
</template>