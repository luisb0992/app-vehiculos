<script setup>
const props = defineProps({
    form: {
        type: Object,
        default: () => ({}),
    },
});
</script>
<template>
    <div>
        <progress
            v-if="form.progress"
            :value="form.progress.percentage"
            max="100"
            class="w-full"
        >
            {{ form.progress.percentage }}%
        </progress>
    </div>
</template>
