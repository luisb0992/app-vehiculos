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
        class="rounded bg-red-200 hover:bg-red-300 inline-flex items-center gap-2 px-3 py-1.5"
        target="_blank"
        noopener="true"
        :download="invoice"
    >
        <span class="text-red-800">Factura</span>
        <i class="fas fa-file-pdf text-red-600"></i>
    </a>
</template>
