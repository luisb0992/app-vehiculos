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
            'text-blue-600 text-xs font-semibold':
                status === $page.props.status.repair_order.open,
            'text-blue-600 text-xs font-semibold':
                status === $page.props.status.repair_order.quoted,
            'text-yellow-600 text-xs font-semibold':
                status === $page.props.status.repair_order.in_repair,
            'text-red-600 text-xs font-semibold':
                status === $page.props.status.repair_order.cancelLed,
            'text-green-600 text-xs font-semibold':
                status === $page.props.status.repair_order.repaired,
            'text-orange-800 text-xs font-semibold':
                status === $page.props.status.repair_order.finalized,
        }"
        class="text-center"
    >
        <!-- por cotizar - abierta -->
        <span v-if="status === $page.props.status.repair_order.open">
            <Link
                :href="route('workshop_quotes.createQuote', id)"
                class="hover:no-underline bg-blue-100 px-3 py-2 hover:bg-blue-300 text-blue-600 hover:text-gray-900 rounded-lg text-xs font-bold"
            >
                Cotizar ahora
            </Link>
        </span>

        <!-- cotizada -->
        <span v-if="status === $page.props.status.repair_order.quoted">
            Reparación cotizada
        </span>

        <!-- en repació -->
        <span v-if="status === $page.props.status.repair_order.in_repair">
            vehiculo en reparación
        </span>

        <!-- orden cancelada -->
        <span v-if="status === $page.props.status.repair_order.cancelLed">
            Orden cancelada
        </span>

        <!-- vehiculo reparado -->
        <span v-if="status === $page.props.status.repair_order.repaired">
            Vehiculo reparado
        </span>

        <!-- caso finalizado -->
        <span v-if="status === $page.props.status.repair_order.finalized">
            <i class="fas fa-check text-green-600"></i>
            Caso finalizado
        </span>
    </div>
</template>
