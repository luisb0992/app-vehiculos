<script setup>
const props = defineProps({
    quotation: {
        type: Object,
        default: {},
    },
});
</script>
<template>
    <button
        class="rounded bg-green-200 hover:bg-green-300 inline-flex items-center justify-center gap-2 px-3 py-2 w-full"
        type="button"
        @click="$emit('openModalInvoice', quotation.id)"
    >
        <i class="fas fa-plus-circle text-green-600"></i>
        <span class="text-green-800 text-xs font-semibold">Agregar factura</span>
    </button>
</template>
