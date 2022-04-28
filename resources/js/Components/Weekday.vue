<script setup>
import OverlayPanel from 'primevue/overlaypanel';
import { ref } from 'vue';

const overlay = ref();
const toggle = function(e) {
    overlay.value.toggle(e);
};

</script>

<template>

    <div class="weekday">
        <OverlayPanel appendTo="body" ref="overlay">
            <slot name="overlay"></slot>
        </OverlayPanel>
        <div class="weekday-inner">
            <div class="weekday-head">
                <a @click="toggle"><slot name="head" /></a>
            </div>

            <div class="weekday-body">

            </div>
        </div>
    </div>

</template>

<style scoped lang="scss">
.weekday {
    flex-basis: calc((100% / 7) - 1px);
    flex-grow: 1;
    border: solid 1px black;
    padding: 5px;
}

.weekday-inner {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>