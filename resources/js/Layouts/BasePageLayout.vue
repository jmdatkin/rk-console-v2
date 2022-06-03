<script setup>
import Authenticated from './Authenticated';
import Panel from 'primevue/panel';
</script>

<template>
    <Authenticated>
        <section>
            <Panel>
                <template #header>
                    <span class="page-header">
                        <slot name="header"></slot>
                    </span>
                </template>
                <slot></slot>
            </Panel>
        </section>
    </Authenticated>
</template>

<style lang="scss">
.page-header {
    font-weight: 600;
    font-size: 2rem;
}
</style>