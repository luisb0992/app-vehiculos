<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    status: Number,
    id: Number,
});
</script>
<template>
    <div
        :class="{
            'text-blue-600 text-xs font-bold':
                status === $page.props.status.repair_order.open,
            'text-yellow-600 text-xs font-bold':
                status === $page.props.status.repair_order.in_repair,
            'text-green-600 text-xs font-bold':
                status === $page.props.status.repair_order.repaired,
            'text-red-600 text-xs font-bold':
                status === $page.props.status.repair_order.canceled,
            'text-purple-600 text-xs font-bold':
                status === $page.props.status.repair_order.closed,
        }"
    >
        <Link
            :href="route('workshop_quotes.createQuote', id)"
            class="hover:no-underline bg-gray-100 px-3 py-2 hover:bg-gray-300 text-blue-600 text-xs font-bold"
            v-if="status === $page.props.status.repair_order.open"
        >
            Cotizar ahora
        </Link>

        <span
            v-else-if="status === $page.props.status.repair_order.in_repair"
            class="text-green-600 text-xs font-bold"
        >
            <i class="fa fa-check fa-2x"></i>
        </span>
        <span
            v-else-if="status === $page.props.status.repair_order.repaired"
            class="text-green-600 text-xs font-bold"
        >
            <i class="fa fa-check fa-2x"></i>
        </span>
        <span
            v-else-if="status === $page.props.status.repair_order.canceled"
            class="text-red-600 text-xs font-bold"
        >
            <i class="fa fa-times fa-2x"></i>
        </span>
        <span
            v-else-if="status === $page.props.status.repair_order.canceled"
            class="text-purple-600 text-xs font-bold"
        >
            <i class="fa fa-times fa-2x"></i>
        </span>
    </div>
</template>
