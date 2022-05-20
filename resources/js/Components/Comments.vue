<script setup>
import Textarea from 'primevue/textarea';
import Comment from './Comment';
import Button from './Button';
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps(['comments']);
</script>

<template>
    <div class="">
        <Comment v-for="comment in comments" :comment="comment"></Comment>
    </div>
</template>