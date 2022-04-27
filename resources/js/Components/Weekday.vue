<script setup>

</script>

<template>

    <div class="weekday">
        <div class="weekday-inner">
            <div class="weekday-head">
                <slot name="head" />
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
}

.weekday-inner {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>