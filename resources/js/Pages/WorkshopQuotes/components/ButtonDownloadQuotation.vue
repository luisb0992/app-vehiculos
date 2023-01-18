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
        class="rounded bg-red-200 hover:bg-red-300 inline-flex items-center gap-2 px-3 py-1.5"
        target="_blank"
        noopener="true"
    >
        <span class="text-red-800">Descargar</span>
        <i class="fas fa-file-pdf text-red-600"></i>
    </a>
</template>
