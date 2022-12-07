<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active','icon']);

const classes = computed(() =>
    props.active
        ? 'p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-blue-500 hover:bg-blue-600'
        : 'p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600'
);
</script>

<template>
    <Link :href="href" :class="classes" >
        <i :class="icon"></i>
        <slot />
    </Link>
</template>
