<script setup>
const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});
</script>
<template>
    <a
        :href="route('workshop_quotes.downloadPDFQuote', id)"
        class="rounded bg-red-200 hover:bg-red-300 inline-flex items-center justify-center gap-2 px-3 py-2 w-full"
        target="_blank"
        noopener="true"
    >
        <i class="fas fa-file-pdf text-red-600"></i>
        <span class="text-red-800 text-xs font-semibold">Cotización</span>
    </a>
</template>
