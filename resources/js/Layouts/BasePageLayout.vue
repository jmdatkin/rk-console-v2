<script setup>
import Authenticated from './Authenticated';
import Panel from 'primevue/panel';
</script>

<template>
    <Authenticated>
        <section>
            <Panel>
                <template #header>
                    <slot name="header"></slot>
                </template>
                <slot></slot>
            </Panel>
        </section>
    </Authenticated>
</template>