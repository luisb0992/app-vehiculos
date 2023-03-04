<script setup>
const props = defineProps({
    invoice: {
        type: String,
        default: null,
    },
});
</script>
<template>
    <a
        :href="$page.props.path.invoices.pp + invoice"
        class="rounded bg-red-600 hover:bg-red-800 inline-flex items-center justify-center gap-2 px-3 py-2 w-full"
        target="_blank"
        noopener="true"
        :download="invoice"
    >
        <i class="fas fa-file-pdf text-white"></i>
        <span class="text-white text-xs font-semibold">Factura</span>
    </a>
</template>
