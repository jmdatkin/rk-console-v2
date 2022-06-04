
<script setup>
import BasePageLayout from './BasePageLayout';
</script>

<template>
    <BasePageLayout>
        <template #header>
            <slot name="header"></slot>
        </template>
        <div class="grid">
            <div class="col-8">
                <slot name="main">

                </slot>
            </div>
            <div class="col-4">
                <slot name="side"></slot>
            </div>
        </div>
    </BasePageLayout>
</template>