<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    id: Number,
});
</script>
<template>
    <Link
        :href="route('workshop_quotes.editQuote', id)"
        class="rounded bg-yellow-600 hover:bg-yellow-700 inline-flex items-center justify-center gap-2 px-3 py-2 w-full text-gray-50 text-xs duration-150 ease-in-out"
    >
        <i class="fas fa-edit"></i>
        Editar
    </Link>
</template>
