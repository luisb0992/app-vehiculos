<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    order: Object,
});
</script>
<template>
    <div
        :class="{
            'text-blue-600 text-xs font-bold':
                order.status === $page.props.status.repair_order.open,
            'text-yellow-600 text-xs font-bold':
                order.status === $page.props.status.repair_order.in_repair,
            'text-green-600 text-xs font-bold':
                order.status === $page.props.status.repair_order.repaired,
            'text-red-600 text-xs font-bold':
                order.status === $page.props.status.repair_order.canceled,
            'text-purple-600 text-xs font-bold':
                order.status === $page.props.status.repair_order.closed,
            'text-blue-400 text-xs font-bold':
                order.status === $page.props.status.repair_order.send,
        }"
    >
        <Link
            :href="route('workshop_quotes.createQuote', order.id)"
            class="hover:no-underline bg-gray-100 px-3 py-2 hover:bg-gray-300 text-blue-600 text-xs font-bold"
            v-if="order.status === $page.props.status.repair_order.open"
        >
            Cotizar ahora
        </Link>

        <span
            v-else-if="
                order.status === $page.props.status.repair_order.in_repair
            "
            class="text-green-600 text-xs font-bold"
        >
            <i class="fa fa-check fa-2x"></i>
        </span>
        <span
            v-else-if="
                order.status === $page.props.status.repair_order.repaired
            "
            class="text-green-600 text-xs font-bold"
        >
            <i class="fa fa-check fa-2x"></i>
        </span>
        <span
            v-else-if="
                order.status === $page.props.status.repair_order.canceled
            "
            class="text-red-600 text-xs font-bold"
        >
            <i class="fa fa-times fa-2x"></i>
        </span>
        <span
            v-else-if="
                order.status === $page.props.status.repair_order.canceled
            "
            class="text-purple-600 text-xs font-bold"
        >
            <i class="fa fa-times fa-2x"></i>
        </span>
        <div
            v-else-if="order.status === $page.props.status.repair_order.send"
            class="text-green-600 text-xs font-bold flex items-center gap-2"
        >
            <i class="fa fa-check fa-2x"></i>

            <a
                :href="route('workshop_quotes.downloadPDFQuote', order.quotation.id)"
                class="rounded bg-gray-200 hover:bg-gray-300 px-5 py-3"
                target="_blank"
                noopener="true"
            >
                <i class="fas fa-file-pdf text-red-600 fa-2x"></i>
            </a>
        </div>
    </div>
</template>
