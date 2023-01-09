<script setup>
defineProps(['value']);
</script>

<template>
    <label class="block font-bold text-sm text-zinc-900">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
